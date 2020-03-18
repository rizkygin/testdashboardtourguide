<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserDetail;
use App\Merchant;
use App\TrxQrcode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserGuideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $guide = User::role('guide')->orderBy('created_at', 'desc')->get();

      if ($request->expectsJson()) {
        return response()->json($guide);
      }

      return view('admin.users.guide_index', compact('guide'));
    }

    public function changeStatus(Request $request, $id){
      $user = User::findOrFail($id);
      $status = $user->status == 1 ? 0 : 1;
      $user->status = $status;
      $user->save();

      return response()->json(['success'=>'Status change successfully']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
      $validator = Validator::make($request->all(), [
        'email' => 'required|email|max:255|unique:users',
        'name' => 'required|max:255',
        'password' => 'required|string|confirmed',
      ]);
      if ($validator->passes()) {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        $user->assignRole('guide');
        $detail = new UserDetail;
        $detail->user_id = $user->id;
        $detail->save();
        return redirect()->route('admin.guide.index')->with('Success','Data Has Been Created!');
      } 
      else return redirect()->back()->withErrors($validator);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = User::where('id', $id)->with('detail', 'merchant', 'qr.promo')->first();  //User itu manggil model yg berisi table. select tinggal panggil kolom. 
        // $count = $data->transactions->count();
        //User::with('detail')->get(); -> contoh manggil table lain istilahnya join table. 
        //pelajarin dokumentasi laravel
        // dd($count);
        $trans = TrxQrcode::with('qrcode.promo.item.merchant')
        ->whereHas('qrcode', function ($q) use ($id) {
        $q->where('user_id', $id);
        })->get();

        $merchants = Merchant::doesntHave('user')->get();
        return view('admin.users.guide_detail', compact('merchants','data', 'id','trans'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
    {
      $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',
        'email' => 'required|email|max:190|unique:users,email,'.$id,
      ]);

      if ($validator->passes()) {
          $data = User::findOrFail($id);
          $data->name = $request->name;
          $data->email = $request->email;
          $data->save();
          return redirect()->route('admin.guide.index')->with('Success','Data has been changed!');
      } else {
          return redirect()->back()->withErrors($validator);            
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
      $user = User::destroy($id);
      if ($request->expectsJson()) {
        return response()->json($user);
      }
    }
}
