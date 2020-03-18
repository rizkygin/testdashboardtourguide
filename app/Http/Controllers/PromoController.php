<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MerchantItem;
use App\Promo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $promos = Promo::with('item')->get();  //User itu manggil model yg berisi table. select tinggal panggil kolom. 
      //User::with('detail')->get(); -> contoh manggil table lain istilahnya join table. 
      //pelajarin dokumentasi laravel
            
      return view('admin.promo.promo_index', compact('promos'));
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
        //
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
