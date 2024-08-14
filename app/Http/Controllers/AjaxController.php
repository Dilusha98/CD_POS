<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BrandValidation;
use App\Http\Requests\UserRoleRequest;
use Exception;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\QueryException;
use App\Exceptions\ErrorCodeException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

//models
use App\Models\Brand;
use App\Models\UserModel;
use App\Models\SavePermissionModel;

class AjaxController extends Controller
{

    public function addNewBrand(BrandValidation $request)
    {
        try {
            $data = $request->validated();

            $logoName = null;
            if ($request->hasFile('logo')) {
                $logoName = saveImage($request->file('logo'));
            }

            $brand = Brand::create([
                'name' => $data['name'],
                'logo' => $logoName,
                'status' => $data['status'],
                'created_by' => auth()->user()->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Brand has been successfully added!',
                'brand' => $brand
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the brand. Please try again later.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | User role create
    |--------------------------------------------------------------------------
    |
    */
    public function createUserRole(UserRoleRequest $request)
    {
        try {
            DB::beginTransaction();

            //create user role
            $UserModel = new UserModel();
            $UserModel->title = $request->roleName;
            $UserModel->created_by = auth()->id();
            $UserModel->updated_by = auth()->id();
            $UserModel->status = 1;
            if (!$UserModel->save()) {
                throw new Exception('user role create failed!');
            }

            //create user role permission
            $permissionCollection = collect(); //permission collection
            if ($request->has('permissions') && count($request->permissions) > 0) {
                foreach ($request->permissions as $permission) {
                    $permissionCollection->push([
                        'user_role' => $UserModel->id,
                        'permission' => $permission,
                    ]);
                }
                if (!SavePermissionModel::insert($permissionCollection->toArray())) {
                    return new Exception('user role permission crate failed!');
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'User role has been successfully added!',
                'user_role' => $UserModel
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the brand. Please try again later.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
