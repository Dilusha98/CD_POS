<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Database\QueryException;
use App\Exceptions\ErrorCodeException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

//models
use App\Models\UserModel;
use App\Models\SavePermissionModel;


class ActionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | User role create
    |--------------------------------------------------------------------------
    |
    */
    public function createUserRole(Request $request)
    {
        try {
            DB::beginTransaction();

            //create user role
            $UserModel = new UserModel();
            $UserModel->title = $request->roleName;
            $UserModel->created_by = auth()->id();
            $UserModel->updated_by = auth()->id();
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
            return redirect()->back()->with('success', 'Data has been saved successfully!');

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Data has been saved failed!' . $e->getMessage());
        }
    }
}
