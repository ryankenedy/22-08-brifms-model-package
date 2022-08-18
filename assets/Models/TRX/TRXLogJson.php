<?php

namespace App\Models\TRX;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TRXLogJson extends Model
{
    use HasFactory;

    protected $connection = 'mysql_trx';
    protected $table = "transaction_log_json";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $casts = [
        'transaction_id'        => 'string',
        'sn'                    => 'string',
        // 'message'               => 'json',
        'created_date'          => 'datetime:Y-m-d H:i:s',
    ];
}
