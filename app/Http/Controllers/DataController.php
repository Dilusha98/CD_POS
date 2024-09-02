<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Database\QueryException;

//models
use App\Models\UserPermissionModel;
use App\Models\Brand;
use App\Models\UserModel;
use App\Models\User;

class DataController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | user Permissions
    |--------------------------------------------------------------------------
    |
    */
    protected function getUserPermission()
    {
        try {
            $data = UserPermissionModel::getUserPermissions();
            $groupedData = $data->groupBy('type')->toArray();
            return $groupedData;
        } catch (Exception $e) {
            return $e;
        }
    }
    /*
    |--------------------------------------------------------------------------
    | get Brands
    |--------------------------------------------------------------------------
    |
    */
    public function getBrands()
    {
        $brands = Brand::with('createdBy')->get();
        return $brands;
    }

    /*
    |--------------------------------------------------------------------------
    | get user role
    |--------------------------------------------------------------------------
    |
    */
    public function getUserRole()
    {
        try {
            $data = UserModel::where('status', 1)->get();
            return $data;
        } catch (Exception $e) {
            return $e;
        }
    }
    /*
    |--------------------------------------------------------------------------
    | get user for edit
    |--------------------------------------------------------------------------
    |
    */
    public function getUserForEdit($userId)
    {
        try {
            $data = User::where('id', $userId)->get();
            return $data;
        } catch (Exception $e) {
            return $e;
        }
    }





    //|--------------------------------------------------------------------------
    //| Chandima Start
    //|--------------------------------------------------------------------------
    /*
    |--------------------------------------------------------------------------
    | get user role for edit
    |--------------------------------------------------------------------------
    |
    */
    public function getUserRoleForEdit($userRoleId)
    {
        try {
            $data = UserModel::selectRaw('user_roles.id, user_roles.*')
                ->with(['getPermissions'])
                ->where('user_roles.id', $userRoleId)
                ->first();

            return $data;
        } catch (Exception $e) {
            dd($e);
            return $e;
        }
    }
    //|--------------------------------------------------------------------------
    //| Chandima End
    //|--------------------------------------------------------------------------
}
