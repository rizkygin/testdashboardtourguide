<?php

namespace App\Exports;

use App\TrxQrcode;
use App\User;
use App\Merchant;
use App\MerchantItem;
use App\Promo;
use App\Qr;

use Illuminate\Support\Facades\DB;
use App\Exports\UserExport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'Name Guide',
            'Item',
            'Category',
            'Value',
            'Merchant Name',
            'Transaction at',
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $month = date('m');
        $year = date('Y');
        $data = TrxQrcode::join('qrcode', 'qrcode.id', '=', 'trx_qrcode.qrcode_id')
        ->join('users','users.id','=','qrcode.user_id')
        ->join('promos','qrcode.promo_id','=','promos.id')
        ->join('merchant_items','promos.item_id','=','merchant_items.id')
        ->join('merchants','merchants.id','=','merchant_items.merchant_id')
        ->select('users.name','merchant_items.name as item_name','promos.category','promos.value','merchants.name as merchant_name','trx_time')
        ->orderBy('trx_time','asc')
        ->whereYear('trx_time', $year)->whereMonth('trx_time', $month)
        ->get();
        // dd($data);
        return $data;
    }
}
