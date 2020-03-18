<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TrxQrcode;
use DataTables;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $years = TrxQrcode::selectRaw('YEAR(trx_time) as year')->orderBy('trx_time', 'desc')->distinct()->get();
      $data = TrxQrcode::with('qrcode.user', 'qrcode.promo.item')->get();

      return view('admin.transaction_index', compact('data', 'years'));
    }

    public function monthlyAjax($date = null){
      if($date == null){
        $month = date('m');
        $year = date('Y');
        $laporan = TrxQrcode::with('qrcode.user', 'qrcode.promo.item.merchant')
        ->orderBy('trx_time','desc')
        ->whereYear('trx_time', $year)->whereMonth('trx_time', $month)
        ->get();
        // dd($laporan);
      }else {
        $time = strtotime($date);
        $month = date("m", strtotime("first day of this month", $time));
        $year = date("Y", strtotime("first day of this month", $time));
        // dd($month, $year);
        $laporan = TrxQrcode::with('qrcode.user', 'qrcode.promo.item.merchant')
        ->orderBy('trx_time','desc')
        ->whereYear('trx_time', $year)->whereMonth('trx_time', $month)
        ->get();
      }
      $array = array();
      foreach ($laporan as $d) {
        $arr['user'] = $d->qrcode->user->name;
        $arr['promo'] = $d->qrcode->promo->item->name ." ".$d->qrcode->promo->category." " .$d->qrcode->promo->value;
        $arr['merchant'] = $d->qrcode->promo->item->merchant->name;
        // dd("test");
        $arr['date'] = $d->trx_time;
        $array[] = $arr;
      }

      
      return Datatables::of($array)
      ->addIndexColumn()
      ->rawColumns(['action'])

      ->make(true);
    }

    public function getMonthly($date = null){
      if($date == null){
        $date = date('Y-m');
        $time = strtotime("now");
        // dd($time);
        $end = date("Y-m", strtotime("+1 month", $time));

        $begin = new \DateTime( $date.'-01' );
        $end = new \DateTime( $end.'-01' );
        // dd($begin, $end, "test1");
      }else {
        $time = strtotime($date);
        // dd($time);
        $end = date("Y-m", strtotime("+1 month", $time));

        $begin = new \DateTime( $date.'-01' );
        $end = new \DateTime( $end.'-01' );
        // dd($begin, $end, "test2");
      }


      $interval = new \DateInterval('P1D');
      $daterange = new \DatePeriod($begin, $interval ,$end);
      
      $month = date("m", strtotime("first day of this month", $time));
      $year = date("Y", strtotime("first day of this month", $time));

      $day = array();
      $value = array();
      $total = TrxQrcode::
      whereYear('trx_time', $year)->whereMonth('trx_time', $month)
      ->count();
      foreach($daterange as $date){
        $day[] = $date->format("j");
        
        $count = TrxQrcode::
        whereDate('trx_time', $date->format("Y-m-d"))
        ->count();

        $value[] = $count;
      }

      return response()->json([
        'status'=>'success',
        'day'=>$day,
        'value'=>$value,
        'total'=>$total,
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
        //
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
