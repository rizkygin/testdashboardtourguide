<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\PromoCollection;
use Illuminate\Support\Facades\Auth;
use App\Promo;
use App\MerchantItem;

class PromoController extends Controller
{
  
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return new PromoCollection(Promo::all());
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
        'value' => 'required|max:255',
        'category' => 'required|max:255',
        'start_time' => 'required|max:255',
        'end_time' => 'required|max:255',
      ])->validate();
      
      $data = new Promo;
      //$tourism->city_id=1;
      $data->item_id = $request->item_id;
      $data->value = $request->value;
      $data->description = $request->description;
      $data->category = $request->category;
      $data->max_cut = $request->max_cut;
      $data->start_time = $request->start_time;
      $data->end_time = $request->end_time;
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
      return new PromoCollection(Promo::where('id', $id)->get());
    }
    /**
     * Display the specified resource. According to logged in user
     *
     * @return \Illuminate\Http\Response
     */
    public function user()
    {
      $user = Auth::user();
      $id = $user->merchant_id;
      if (!$id) {
        return response()->json([
          'status'=>'error',
          'message'=>'Merchant not assigned.',
        ]);
      }
      return new PromoCollection(
        Promo::whereHas('item', function ($q) use ($id) {
          $q->where('merchant_id', $id);
      })->get()
      );
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
        'value' => 'required|max:255',
        'category' => 'required|max:255',
        'start_time' => 'required|max:255',
        'end_time' => 'required|max:255',
      ])->validate();
      
      $data = Promo::findOrFail($id);

      $data->value = $request->value;
      $data->description = $request->description;
      $data->category = $request->category;
      $data->max_cut = $request->max_cut;
      $data->start_time = $request->start_time;
      $data->end_time = $request->end_time;
      // dd($request);
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
      $data = Promo::destroy($id);
      return response()->json([
        'status' => $this->successStatus,
        'result' => $data
      ]); 
    }
}
