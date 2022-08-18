<?php

namespace App\Models\MS;

use App\Models\MM\TerminalMaster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReqChangeStok extends Model
{
    use HasFactory;

    protected $connection = 'mysql_ms';
    protected $table = "req_change_stok";
    protected $primaryKey = 'id';

    protected $fillable = [
        'poi',
        'awal_stok_id',
        'akhir_stok_id',
        'status',
        'keterangan',
        'created_at',
    ];
}
