<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\UserDetail;
use App\Qr;
use App\TrxQrcode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\URL;
use Illuminate\Contracts\Encryption\DecryptException;

class QrCodeController extends Controller
{
  public $successStatus = 200;

  public function generate($id){
    $uid = Auth::guard('api')->id();
    $dt = Carbon::now()->addWeek();

    $data = Qr::create([
      'user_id'=>$uid,
      'promo_id'=>$id,
      'expiry_time'=>$dt,
    ]);
    // $param = Crypt::encrypt($data->id);
    // dd($param);
    $qr_data = encrypt($data->id);

    $image = QrCode::format('svg')->size(300)->generate($qr_data);
    // $path = Storage::put('qrcode/file.png', $image);
    $path = 'qrcode/qr-' . $data->id .'-'. time() . '.svg';
    
    Storage::put('public/'.$path, $image);
    // $path = Storage::disk('public')->putFile('qrcode', $image, 'public');

    return response()->json([
      'status'=>'success',
      'result'=>asset('storage/'.$path)
    ]);
  }

  public function scan($id){
    try {
      $decrypted = decrypt($id);
    } catch (DecryptException $e) {
        return response()->json($e); 
    }
    //http://127.0.0.1:8000/api/qr/scan/eyJpdiI6ImoraUcwdWxIME1TTkV5UzExSEJDd3c9PSIsInZhbHVlIjoiZjJmcG9JRkJicDhoZlwvU3JBRDZkWFE9PSIsIm1hYyI6IjlkMTYwNmM1OGZhZGRiMDZlYjMwMmNjNmNhMjUzM2MyNmI2ZjFmNWU5MjNiMzhlODA1NGZiYWZlMjA2YjhjYTcifQ==
    // dd($id, $decrypted);
    $dt = Carbon::now();
    $qr = Qr::where('id', $decrypted)->with('promo')->first();
    $user = User::findOrFail($qr->user_id);

    $data = TrxQrcode::create([
      'qrcode_id'=>$decrypted,
      'trx_time'=>$dt,
    ]);
    $user->increment('points', 5);
    
    return response()->json([
      'status'=>'success',
      'user'=>$user,
      'promo'=>$qr->promo,
    ]);
  }
}
