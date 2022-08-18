<?php

namespace App\Models\MS;

use App\Models\MM\TerminalMaster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubTiket extends Model
{
    use HasFactory;

    protected $connection = 'mysql_ms';
    protected $table = "ms_sub_tiket";
    protected $primaryKey = 'id_sub_tiket';
    public $timestamps = false;

    protected $fillable = [
        'poi_capture',
        'id_list_stok',
        'id_officer',
        'id_kategori',
        'id_tiket',
        'jenis_pasang',
        'keterangan',
        'status',
        'is_integrated',
        'id_for_vendor',
        'created_at'
    ];

    protected $appends = ['done'];
    
    public function getDoneAttribute()
    {
        if($this->status == 3) return true;
        return false;
    }
}
