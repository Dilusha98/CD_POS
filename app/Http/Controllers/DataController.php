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
}
