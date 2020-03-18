<?php

namespace App\Exports;

use App\User;
use App\UserDetail;

use Illuminate\Support\Facades\DB;
use App\Exports\UserExport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings, 
{
    public function headings(): array
    {
        return [
            'No',
            'User Name',
            'Email',
            'Address',
            'Phone Number',
            'Occupation',
            'Register at',
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $users = User::join('user_detail', 'users.id', '=', 'user_detail.user_id')
        ->select('users.id','users.name','users.email', 'user_detail.address', 'user_detail.phone_number','user_detail.ocupation','users.created_at')
        ->get();
        
        return $users;
    }
}
