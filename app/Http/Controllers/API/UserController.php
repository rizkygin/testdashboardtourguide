<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\UserDetail;

class UserController extends Controller
{

    public $successStatus = 200;

    public function login(Request $request){
      if(Auth::attempt([
        'email' => request('email'),
        'password' => request('password')
      ])){
        $user = Auth::user();
        if ($user->status == 0) {
          return response()->json([
            'status' => 'error',
            'message' => 'Your account is deactivated, please call the customer service to activate your account.'
          ]);
        } 
        $role = $user->getRoleNames()->first();
        return response()->json([
          'status' => 'sukses',
          'user' => $user,
          'role' => $role,
          'token' => $user->createToken('API_Travel')->accessToken
        ]);
      }
      else{
        return response()->json(['error'=>'Unauthorised'], 401);
      }
    }

    public function register(Request $request)
    {
      $validator = Validator::make($request->all(), [
          'name' => 'required',
          'email' => 'required|email|unique:users',
          'password' => 'required|min:6|confirmed',
      ]);
		  if ($validator->fails()) {
        return response()->json(['error'=>$validator->errors()], 401);
      }
      $user = User::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>bcrypt($request->password),
      ]);
      $user->assignRole('guide');
      $detail = new UserDetail;
      $detail->user_id = $user->id;
      $detail->save();
		  return response()->json([
        'status'=>'success',
        'result'=>$user
      ]);
    }

    public function getUser() {
      $user = Auth::guard('api')->user();
      $id = Auth::id();
      $detail = UserDetail::where('user_id', $id);
      return response()->json(['user' => $user, 'detail' => $detail], $this->successStatus); 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      $id = Auth::id();
      $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',
        'phone_number' => 'max:14',
        'email' => 'required|email|max:190|unique:users,email,'.$id,
        'photo' => 'image|mimes:jpeg,jpg,png,gif|required|max:2048',
      ]);
      if ($validator->fails()) {
        return response()->json(['error'=>$validator->errors()], 401);
      }
      $data = User::findOrFail($id);
      $data->name = $request->name;
      $data->email = $request->email;
      $data->save();
      $detail = UserDetail::where('user_id', $id)->first();
      $photo = Storage::disk('public')->putFile('merchant',$request->file('photo'), 'public');
      $detail->photo = $photo;
      $detail->address = $request->address;
      $detail->phone_number = $request->phone_number;
      $detail->ocupation = $request->ocupation;
      $detail->save();
      
      return response()->json([
        'status'=>'success',
        'user'=>$data,
        'detail'=>$detail,
      ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
