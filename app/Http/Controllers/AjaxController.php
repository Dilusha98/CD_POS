<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BrandValidation;
use App\Models\Brand;
use Exception;

class AjaxController extends Controller
{

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

}
