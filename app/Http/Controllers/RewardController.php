<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reward;
use App\TrxReedem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class RewardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $data = Reward::with('trx')->get();
            
      return view('admin.reward.reward_index', compact('data'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reedemIndex()
    {
      $data = TrxReedem::with('reward', 'user')->get();
            
      return view('admin.reward.reedem_index', compact('data'));
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
        'point' => 'required',
      ])->validate();
      // dd($validator);
      // dd('test');
      $data = new Reward;
      $data->name = $request->name;
      $data->point = $request->point;
      $photo = Storage::disk('public')->putFile('reward', $request->file('photo'), 'public');
      $data->photo = $photo;
      $data->description = $request->description;
      $data->save();
      return redirect()->route('admin.reward.index')->with('Success','Data Has Been Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $data = Reward::where('id', $id)->first();  //User itu manggil model yg berisi table. select tinggal panggil kolom. 
      //User::with('detail')->get(); -> contoh manggil table lain istilahnya join table. 
      //pelajarin dokumentasi laravel
            
      return route('admin.reward.index', compact('data'));
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
        'point' => 'required',
      ])->validate();
      // dd($validator);
      // dd('test');
      $data = Reward::findOrFail($id);
      $data->name = $request->name;
      $data->point = $request->point;
      $photo = Storage::disk('public')->putFile('reward',$request->file('photo'), 'public');
      $data->photo = $photo;
      $data->description = $request->description;
      $data->save();
      return redirect()->route('admin.reward.index')->with('Success','Data Has Been Changed!');    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
      $data = Reward::destroy($id);
      if ($request->expectsJson()) {
        return response()->json($data);
      }
    }
}
