<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\TourismCollection;
use App\Tourism;

class TourismController extends Controller
{
  
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return new TourismCollection(Tourism::all());
    }
    /**
     * Display a listing of the Merchant based on the city.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexCity($id)
    {
      return new TourismCollection(Tourism::where('city_id', $id)->get());
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
        'address' => 'required|max:255',
        'name' => 'required|max:255',
        'photo' => 'image|mimes:jpeg,jpg,png,gif|required|max:10000',
      ])->validate();
      
      $tourism = new Merchant;
      //$tourism->city_id=1;
      $tourism->category_id = $request->category_id;
      $tourism->name = $request->name;
      $tourism->description = $request->description;
      $photo = Storage::disk('public')->putFile('merchant',$request->file('photo'), 'public');
      $tourism->photo = $photo;
      $tourism->address = $request->address;
      $tourism->latitude = $request->latitude;
      $tourism->longitude = $request->longitude;
      // dd($request);
      $tourism->save();

      return response()->json([
        'status' => $this->successStatus,
        'result' => $tourism
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
        'address' => 'required|max:255',
        'name' => 'required|max:255',
      ])->validate();
      
      $tourism = Merchant::findOrFail($id);
      //$tourism->city_id=1;

      $tourism->category_id = $request->category_id;
      $tourism->name = $request->name;
      $tourism->address = $request->address;
      if ($request->description) {
        $tourism->description = $request->description;
      }
      if ($request->photo) {
        $photo = Storage::disk('public')->putFile('merchant',$request->file('photo'), 'public');
        $tourism->photo = $photo;
      }
      if ($request->latitude) {
        $tourism->latitude = $request->latitude;
      }
      if ($request->longitude) {
        $tourism->longitude = $request->longitude;
      }
      // dd($request);
      $tourism->save();

      return response()->json([
        'status' => $this->successStatus,
        'result' => $tourism
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
