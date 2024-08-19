<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BrandValidation;
use App\Http\Requests\brandEditValidation;
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

    /*
    |--------------------------------------------------------------------------
    | create brand
    |--------------------------------------------------------------------------
    |
    */
    public function addNewBrand(BrandValidation $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

            $logoName = null;
            if ($request->hasFile('logo')) {
                $logoName = saveImageWebp($request->file('logo'));
            }

            $brand = Brand::create([
                'name' => $data['name'],
                'logo' => $logoName,
                'status' => $data['status'],
                'created_by' => auth()->user()->id,
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Brand has been successfully added!',
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

    /*
    |--------------------------------------------------------------------------
    | get brand List
    |--------------------------------------------------------------------------
    |
    */
    public function brandList() {

        if(!isPermissions('brand_list')){
            return response()->json([
                'message' => 'You do not have permission to view the brand list.'
            ], 403);
        }

        $brands = Brand::with('createdBy')->get();
        return response()->json(['brands' => $brands]);
    }

    /*
    |--------------------------------------------------------------------------
    | get brand
    |--------------------------------------------------------------------------
    |
    */
    public function getBrand($id) {

        if(!isPermissions('brand_list')){
            return response()->json([
                'message' => 'You do not have permission to view the brand list.'
            ], 403);
        }

        $brand = Brand::with('createdBy')->where('id',$id)->get();
        return response()->json($brand);
    }


    /*
    |--------------------------------------------------------------------------
    | Edit brand
    |--------------------------------------------------------------------------
    |
    */
    public function editNewBrand(BrandEditValidation $request, $id)
    {
        try {
            DB::beginTransaction();


            $data = $request->validated();

            $brand = Brand::findOrFail($id);
            if ($request->hasFile('brandLogoEdit')) {

                $logoName = saveImageWebp($request->file('brandLogoEdit'));
                if ($brand->logo) {
                    deleteImage($brand->logo);
                }

            } else {
                $logoName = $brand->logo;
            }

            $brand->update([
                'name' => $data['brandNameEdit'],
                'logo' => $logoName,
                'status' => $data['brandStatusEdit'],
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Brand has been successfully updated!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the brand. Please try again later.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}
