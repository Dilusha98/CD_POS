<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BrandValidation;
use App\Models\Brand;
use Exception;

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

            return response()->json([
                'success' => true,
                'message' => 'Brand has been successfully added!',
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


}
