<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserDetail;
use App\Merchant;
use App\Promo;
use App\TrxQrcode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserMerchantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $merchants = User::role('merchant')->with('merchant')->orderBy('created_at', 'desc')->get();
      $merchant_list = Merchant::doesntHave('user')->get();

      if ($request->expectsJson()) {
        return response()->json($merchants);
      }

      return view('admin.users.merchants_index', compact('merchants', 'merchant_list'));
    }

    public function setMerchant(Request $request, $id){
      $user = User::findOrFail($id);
      $user->merchant_id = $request->merchant_id;
      $user->save();
      return redirect()->route('admin.merchant.show', $id)->with('Success','Merchant has been set!');
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
        $user->assignRole('merchant');
        $detail = new UserDetail;
        $detail->user_id = $user->id;
        $detail->save();
        return redirect()->route('admin.merchant.index')->with('Success','Data Has Been Created!');
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
      $data = User::where('id', $id)->with('detail', 'merchant')->first();  //User itu manggil model yg berisi table. select tinggal panggil kolom. 
      //User::with('detail')->get(); -> contoh manggil table lain istilahnya join table. 
      //pelajarin dokumentasi laravel
      // dd($data);
      $trans = TrxQrcode::with('qrcode.promo.item.merchant','qrcode.user')
        ->whereHas('qrcode', function ($q) use ($id) {
        $q->where('user_id', $id);
        })->get();

      $merchants = Merchant::doesntHave('user')->get();
      $promos = Promo::whereHas('item', function ($q) use ($id) {
          $q->where('merchant_id', $id);
      })->get();
      //dd($promos);
      return view('admin.users.merchant_detail', compact('merchants', 'data', 'id','trans'));
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
          if($request->merchant_id){
            $data->merchant_id = $request->merchant_id;
          }
          $data->save();
          return redirect()->route('admin.merchant.index')->with('Success','Data has been changed!');
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
