<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\User;
use App\Models\raffel;
use Auth;

class viewController extends DataController
{

    /*
    |--------------------------------------------------------------------------
    | Public Function Default
    |--------------------------------------------------------------------------
    |
    */
    public function default($data)
    {

        // Defalut css
        $css = array(
            config('site-specific.datatable-css'),
            config('site-specific.datatable-btn-css'),
            config('site-specific.datatable-bootstrap-css'),
            config('site-specific.dropify-css'),
            config('site-specific.sweetAlert-css'),
            config('site-specific.toastr-css'),
        );

        //Default script
        $script = array(
            config('site-specific.jquery-min-js'),
            config('site-specific.jquery-ui-min-js'),
            config('site-specific.datatable-js'),
            config('site-specific.datatable-button-js'),
            config('site-specific.datatable-html5-js'),
            config('site-specific.datatable-print-js'),
            config('site-specific.datatable-jszip-js'),
            config('site-specific.datatable-pdfmake-js'),
            config('site-specific.datatable-pdffont-js'),
            config('site-specific.datatable-colVis-js'),
            config('site-specific.datatable-btn-bootstrap-js'),
            config('site-specific.jquery-validation-js'),
            config('site-specific.dropify-js'),
            config('site-specific.sweetAlert-js'),
            config('site-specific.toastr-js'),
        );

        if (isset($data['css'])) {
            $data['css'] = array_merge($css, $data['css']);
        } else {
            $data['css'] = $css;
        }
        if (isset($data['script'])) {
            $data['script'] = array_merge($script, $data['script']);
        } else {
            $data['script'] = $script;
        }

        return View::make('dashboard', $data);
    }


    /*
    |--------------------------------------------------------------------------
    | Public Function Dashboard
    |--------------------------------------------------------------------------
    |
    */
    public function index()
    {

        $data = array(
            'title'                 => 'Dashboard',
            'view'                  => 'home',
            // 'css'                   => array(config('site-specific.morris-css')), //example to custom css
            // 'script'                => array(config('site-specific.morris-min-js')), //example to custom js
            // 'dashboard_data'        => $this->dashboardData(Auth::User()->branch), //example to custome function
        );

        return $this->default($data);
    }


    /*
    |--------------------------------------------------------------------------
    | Public Function Brand
    |--------------------------------------------------------------------------
    |
    */
    public function brand()
    {

        $data = array(
            'title'                 => 'Brand',
            'view'                  => 'product/brand',
            'script'                => array(config('site-specific.brand-js')),
            'brands'                => $this->getBrands(),
        );

        return $this->default($data);
    }
    /*
    |--------------------------------------------------------------------------
    | Public Function User Role
    |--------------------------------------------------------------------------
    |
    */
    public function userRole()
    {

        $data = array(
            'title'                 => 'User Role',
            'view'                  => 'user_role/create_user_role',
            'script'                => array(config('site-specific.create-user-role-js')),
            'groupedData'           => $this->getUserPermission(),
        );

        return $this->default($data);
    }
    /*
    |--------------------------------------------------------------------------
    | Public Function Create User
    |--------------------------------------------------------------------------
    |
    */
    public function createUser()
    {

        $data = array(
            'title'                 => 'Create User',
            'view'                  => 'user_role/create_user',
            'script'                => array(config('site-specific.create-user-js')),
        );

        return $this->default($data);
    }
}
