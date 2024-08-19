<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BrandValidation;
use App\Http\Requests\brandEditValidation;
use App\Http\Requests\UserRoleRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\CreateUserPasswordValidationRequest;
use Exception;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\QueryException;
use App\Exceptions\ErrorCodeException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

//models
use App\Models\Brand;
use App\Models\UserModel;
use App\Models\SavePermissionModel;
use App\Models\User;

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
    public function brandList()
    {

        if (!isPermissions('brand_list')) {
            return response()->json([
                'message' => 'You do not have permission to view the brand list.'
            ], 403);
        }

        $brands = Brand::with('createdBy')->get();
        return response()->json(['brands' => $brands]);
    }
    /*
    |--------------------------------------------------------------------------
    | check phone number existing
    |--------------------------------------------------------------------------
    | .....
    */
    public function phoneNumberValidation(Request $request)
    {
        try {
            $status = User::where('phone', $request->value)->where('id', '!=', $request->id)->exists();
            return response()->json($status);
        } catch (\Throwable $th) {
            return response()->json(false);
        }
    }
    /*
    |--------------------------------------------------------------------------
    | User create
    |--------------------------------------------------------------------------
    |
    */
    public function saveUser(CreateUserRequest $request)
    {

        if (!isPermissions('create_user')) {
            return response()->json([
                'message' => 'You do not have permission to view the create user.'
            ], 403);
        }

        try {
            DB::beginTransaction();
            $data = $request->validated();

            $User = new User();
            $User->name = $data['firatName'];
            $User->email = $data['userEmail'];
            $User->email_verified_at = null;
            $User->password = Hash::make($data['password']);
            $User->last_name = $data['LastName'];
            $User->phone = $data['phoneNo'];
            $User->dob = $data['dob'];
            $User->address = $data['address'];
            $User->user_role = $data['userRole'];
            $User->username = $data['userName'];
            $User->status = 1;
            $User->remember_token = null;
            if (!$User->save()) {
                throw new Exception('user create failed!');
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'User has been successfully added!',
                'user' => $User
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
    /*
    |--------------------------------------------------------------------------
    | check user name existing
    |--------------------------------------------------------------------------
    | .....
    */
    public function userNameValidation(Request $request)
    {
        try {
            $status = User::where('username', $request->value)->where('id', '!=', $request->id)->exists();
            return response()->json($status);
        } catch (\Throwable $th) {
            return response()->json(false);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | check user email existing
    |--------------------------------------------------------------------------
    | .....
    */
    public function userEmailValidation(Request $request)
    {
        try {
            $status = User::where('email', $request->value)->where('id', '!=', $request->id)->exists();
            return response()->json($status);
        } catch (\Throwable $th) {
            return response()->json(false);
        }
    }
    /*
    |--------------------------------------------------------------------------
    | get user List
    |--------------------------------------------------------------------------
    |
    */
    public function getUserList()
    {

        if (!isPermissions('user_list')) {
            return response()->json([
                'message' => 'You do not have permission to view the user list.'
            ], 403);
        }

        $users = User::selectRaw('users.*, a.title')
            ->leftJoin('user_roles as a', 'a.id', 'users.user_role')
            ->get();
        return response()->json(['users' => $users]);
    }
    /*
    |--------------------------------------------------------------------------
    | check current password
    |--------------------------------------------------------------------------
    |
    */
    public function currentPasswordCheckValidation(Request $request)
    {
        try {
            $user = User::find($request->id);
            if (!$user) {
                Log::error("User not found for ID: {$request->id}");
                return response()->json(false);
            }

            $inputLength = strlen($request->value);
            $dbHashLength = strlen($user->password);

            Log::info("Password check for user {$request->id}:");
            Log::info("Input password length: {$inputLength}");
            Log::info("Stored hash length: {$dbHashLength}");

            $status = Hash::check($request->value, $user->password);
            Log::info("Password match result: " . ($status ? 'Success' : 'Failure'));

            return response()->json($status);
        } catch (\Throwable $th) {
            Log::error("Error in password validation: " . $th->getMessage());
            return response()->json(false);
        }
    }
    /*
    |--------------------------------------------------------------------------
    | save new password
    |--------------------------------------------------------------------------
    |
    */
    public function saveResetPassword(CreateUserPasswordValidationRequest $request)
    {
        if (!isPermissions('user_edit')) {
            return response()->json([
                'message' => 'You do not have permission to view the user edit.'
            ], 403);
        }

        try {
            DB::beginTransaction();
            $data = $request->validated();


            $user = User::find($request->hideUserId);
            if (!$user) {
                throw new Exception('User not found!');
            }

            // Update only the password column
            $user->password = Hash::make($data['newPassowrd']);
            $user->save(); // This will only update the changed attributes


            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'The password reset is successful!',
                'user' => $user
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'There was an error resetting the password. Please try again!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }






    //|--------------------------------------------------------------------------
    //| Chandima Start
    //|--------------------------------------------------------------------------


    //|--------------------------------------------------------------------------
    //| Chandima End
    //|--------------------------------------------------------------------------


}
