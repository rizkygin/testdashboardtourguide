<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GalleryTourism;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = GalleryTourism::all();

        return view('admin.tourism.tourism_detail', compact('data'));
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
            'description' => 'required',
            //'longitude' => 'required',
            //'latitude' => 'required',
            'photo' => 'image|mimes:jpeg,jpg,png,gif|required|max:10000',
          ]);
          if ($validator->passes()) {
            $gal = new GalleryTourism;
            $gal = Storage::disk('public')->putFile('gallery',$request->file('photo'), 'public');
            $gal->photo = $photo;
            $gal->description = $request->description;
            $gal->save();
            //dd($tourism);
            return redirect()->route('admin.gallery.index',compact('gal'))->with('Success','Data Has Been Created!');
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
