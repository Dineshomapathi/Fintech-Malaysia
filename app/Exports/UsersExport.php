<?php

namespace App\Exports;

use App\Message;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

class UsersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $excel = DB::select('
        SELECT messages.id, A1.loginotp AS Sender , A2.loginotp AS Receiver, messages.read, messages.text, messages.created_at, messages.updated_at 
        FROM messages
        INNER JOIN users A1 ON messages.from=A1.id
        INNER JOIN users A2 ON messages.to=A2.id
        ');

        return collect($excel);
    }
}
