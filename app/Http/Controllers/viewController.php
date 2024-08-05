<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\User;
use App\Models\raffel;
use Auth;

class viewController extends Controller
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
        $css =array(

        );

        //Default script
        $script =array(
            config('site-specific.jquery-min-js'),
            config('site-specific.jquery-ui-min-js'),
        );

        if(isset($data['css'])){
            $data['css'] = array_merge($css,$data['css']);
        }else{
            $data['css'] = $css;
        }
        if(isset($data['script'])){
            $data['script'] = array_merge($script,$data['script']);
        }else{
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
    public function index(){

        $data =array(
            'title'                 => 'Dashboard',
            'view'                  => 'home',
            // 'css'                   => array(config('site-specific.morris-css')), //example to custom css
            // 'script'                => array(config('site-specific.morris-min-js')), //example to custom js
            // 'dashboard_data'        => $this->dashboardData(Auth::User()->branch), //example to custome function
        );

        return $this->default($data);
    }

}
