<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Database\QueryException;

//models
use App\Models\UserPermissionModel;

class DataController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Test
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
}
