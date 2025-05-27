<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use App\UserDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
       // auth()->setDefaultDriver('api');
        $token = Auth::attempt($credentials);

        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }
        $user = Auth::user();

        if($user->type == 'admin'){
            Auth::logout();
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);

        $token = auth()->attempt($credentials);
        if($token === false){
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' =>'required',
            'email' =>'required|email',
            'phone' =>'required',
            'password' =>'required|min:6',
        ]);

        if ($validator->fails()) {
            return  $this->sendError('Error','Something went wrong');
        }

        $exist = User::where('type','user')->where('email',$request->email)->first();
        if ($exist){
            return  $this->sendError('Error','Already registered with this email');
        }

        $new_user = new user();
        $slug = str_slug($request->name);
        $new_user->name = $request->name;
        $new_user->email = $request->email;
        $new_user->slug = $slug;
        $new_user->type = 'user';
        $new_user->status  = true;
        $new_user->email_verified_at = Carbon::now();
        $new_user->phone = $request->phone;
        $new_user->password = Hash::make($request->password);
        $new_user->save();

        return $this->sendResponse('Success', 'Registration successfully done');
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    public function user_info()
    {
        $user = auth('api')->user();
        $data['user'] = $user;
        $data['user_details'] = UserDetail::where('user_id',$user->id)->first();

        return $this->sendResponse($data, 'Data fetched successfully');
    }

    public function profile_update(Request $request)
    {
        $user = User::where('id', auth('api')->user()->id)->first();
        $this->validate($request,[
            'name' =>'required',
            'email' =>'required|email',
            'phone' =>'required',
            'district_id' =>'required',
            'address_1' =>'required',
            'address_2' =>'nullable',
            'zip' =>'required',
            'password' =>'nullable|min:6',
            'image' => 'nullable|mimes:jpg,jpeg,png|max:1024',
        ]);

        $slug = str_slug($request->name);
        $user->name = $request->name;
        $user->slug = $slug;
        $user->phone = $request->phone;
        if ($request->password){
            $user->password = Hash::make($request->password);
        }
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $file_name = 'image'.uniqid().rand(000,9999).'.'. $file->getClientOriginalExtension();
            $file->move('uploads/user/',$file_name);
            if ($user->image != null){
                unlink($user->image);
            }
            $user->image = 'uploads/user/' . $file_name;
        }
        $user->save();

        $data['user_id'] = $user->id;
        $data['district_id'] = $request->district_id;
        $data['address_1'] = $request->address_1;
        $data['address_2'] = $request->address_2;
        $data['zip'] = $request->zip;
        $data['account_status'] = 'active';

        $user_detail = UserDetail::where('user_id',$user->id)->first();
        if ($user_detail){
            $user_detail->update($data);
        }
        else{
            UserDetail::create($data);
        }

        return $this->sendResponse('Success', 'Profile Updated successfully');
    }
}
