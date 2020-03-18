<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\MerchantCollection;
use Illuminate\Support\Facades\Auth;
use App\Merchant;
use App\MerchantItem;

class MerchantItemController extends Controller
{
  
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return new MerchantCollection(Merchant::all());
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
      $user = Auth::user();
      $id = $user->merchant_id;
      if (!$id) {
        return response()->json([
          'status'=>'error',
          'message'=>'Merchant not assigned.',
        ]);
      }
      Validator::make($request->all(), [
        'name' => 'required|max:255',
        'price' => 'required',
        'photo' => 'image|mimes:jpeg,jpg,png,gif|max:10000',
      ])->validate();
      
      $data = new MerchantItem;
      //$tourism->city_id=1;
      $data->merchant_id = $id;
      $data->name = $request->name;
      $data->description = $request->description;
      $photo = Storage::disk('public')->putFile('items',$request->file('photo'), 'public');
      $data->photo = $photo;
      $data->price = $request->price;
      $data->save();

      return response()->json([
        'status' => $this->successStatus,
        'result' => $data
      ]); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      return new MerchantCollection(Merchant::where('id', $id)->get());
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
      Validator::make($request->all(), [
        'name' => 'required|max:255',
        'price' => 'required',
        'photo' => 'image|mimes:jpeg,jpg,png,gif|max:10000',
      ])->validate();
      
      $data = MerchantItem::findOrFail($id);
      $data->name = $request->name;
      $data->description = $request->description;
      $photo = Storage::disk('public')->putFile('items',$request->file('photo'), 'public');
      $data->photo = $photo;
      $data->price = $request->price;
      $data->save();

      return response()->json([
        'status' => $this->successStatus,
        'result' => $data
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
      $data = MerchantItem::destroy($id);
      return response()->json([
        'status' => $this->successStatus,
        'result' => $data
      ]); 
    }
}
