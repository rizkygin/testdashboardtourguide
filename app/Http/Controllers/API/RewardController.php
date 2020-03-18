<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\RewardCollection;
use App\Reward;
use App\User;
use App\TrxReedem;
use Carbon\Carbon;

class RewardController extends Controller
{
  
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return new RewardCollection(Reward::all());
    }

    public function reedem($id){
      $uid = \Auth::id();
      $dt = Carbon::now();
      $reward = Reward::findOrFail($id);

      $user = User::findOrFail($uid);
      if ($user->points >= $reward->point) {
        $data = TrxReedem::create([
          'user_id'=>$uid,
          'reward_id'=>$id,
          'created_at'=>$dt,
        ]);
        $user->decrement('points', $reward->point);      
      } else {
        return response()->json([
          'status'=>'error',
          'message'=>'points not enough',
        ]);
      }
      
      return response()->json([
        'status'=>'success',
        'reward'=>$reward,
      ]);
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
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      return new RewardCollection(Reward::where('id', $id)->get());
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
