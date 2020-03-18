<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notif = Notification::all();

        return view('admin.notification',compact('notif'));
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
            'description' => 'required|max:255',
            'name' => 'required|max:100',
            //'description' => 'required',
            //'longitude' => 'required',
            //'latitude' => 'required',
            //'photo' => 'image|mimes:jpeg,jpg,png,gif|required|max:10000',
          ]);
          if ($validator->passes()) {
            $notif = new Notification;
            //$tourism->city_id=1;
            $notif->name = $request->name;
            $notif->description = $request->description;
            // dd($request);
            $notif->save();
            return redirect()->route('admin.notification.index',compact('notif'))->with('Success','Data Has Been Created!');
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
        
        $validator = Validator::make($request->all(), [
            'description' => 'required|max:255',
            'name' => 'required|max:100',
            //'description' => 'required',
            //'longitude' => 'required',
            //'latitude' => 'required',
            //'photo' => 'image|mimes:jpeg,jpg,png,gif|required|max:10000',
          ]);
          if ($validator->passes()) {
            $notif =Notification::findorfail($id);
            //$tourism->city_id=1;
            $notif->name = $request->name;
            $notif->description = $request->description;
            // dd($request);
            $notif->save();
            return redirect()->route('admin.notification.index',compact('notif'))->with('Success','Data Has Been Changed!');
        }
        else return redirect()->back()->withErrors($validator);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
      $notif = Notification::destroy($id);
      if ($request->expectsJson()) {
        return response()->json($notif);
      }
    }
}
