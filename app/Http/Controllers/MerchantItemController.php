<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MerchantItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class MerchantItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index (Request $request)
    {
    
        $items = MerchantItem::all();


      if ($request->expectsJson()) {
        return response()->json($items);
      }

      return view('admin.places.merchant_detail', compact('items'));
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
      
      Validator::make($request->all(), [
        'name' => 'required|max:255',
        'price' => 'required',
        //'photo' => 'image|mimes:jpeg,jpg,png,gif|max:10000',
      ])->validate();
      
      $data = new MerchantItem;
      //$tourism->city_id=1;
      $data->merchant_id = $request->merchant_id;
      $data->name = $request->name;
      $data->description = $request->description;
      $photo = Storage::disk('public')->putFile('items',$request->file('photo'), 'public');
      $data->photo = $photo;
      $data->price = $request->price;
      $data->save();

      return redirect()->back();
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $data = MerchantItem::where('id', $id)->first();

      return view('admin.places.merchant_detail', compact('data'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
      $data = MerchantItem::destroy($id);
      if ($request->expectsJson()) {
        return response()->json($data);
      }
    }
}
