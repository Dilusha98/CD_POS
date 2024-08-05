<?php

if($_ENV['APP_ENV'] == 'live') {
    $BaseUrl     = '';
}
else if($_ENV['APP_ENV'] == 'dev'){
    $BaseUrl     = '';
}
else{
    $BaseUrl     = 'http://127.0.0.1:8000/';
}

$version = 1;
return [
    /*
    |--------------------------------------------------------------------------
    | System configurations
    |--------------------------------------------------------------------------
    */

    // 'attempt-limit'=> 5,
    // 's3-bucket-notification-image-path' => 'ceylonex/notification-images/',
    // 'defult-image'                      => '/custom_assets/img/dummy-profile.png',
    'Base-url'            => $BaseUrl,

    /*
    |--------------------------------------------------------------------------
    | Site Default styles
    |--------------------------------------------------------------------------
    */





    /*
    |--------------------------------------------------------------------------
    | Site Default script
    |--------------------------------------------------------------------------
    */
    'jquery-min-js'                 => "plugins/jquery/jquery.min.js",

    'jquery-ui-min-js'                 => "plugins/jquery-ui/jquery-ui.min.js",

    // Custom js example
    // 'notification-init-js'              =>"/custom_assets/js/notification-init.js?v=".$version,











    'districts'                     => ['Colombo','Gampaha','Kalutara','Ratnapura','Galle','Kegalla','Kurunegala','Puttalam','Matara','Kandy','Nuwara Eliya','Matale','Anuradhapura','Moneragala','Ampara','Trincomalee','Mullaittivu','Badulla','Batticalao','Hambanthota','Mannar','Jaffna','Polonnaruwa','Vavuniya'],
    'provinces'                     => ['Western Province','Sabaragamuwa Province','Southern Province','North Western Province','Central Province','North Central Province','Uva Province','Eastern Province','Nothern Province'],

];






