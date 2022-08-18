<?php

namespace App\Models\MS;

use App\Models\HB\HBTerminal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokMaster extends Model
{
    use HasFactory;

    protected $connection = 'mysql_ms';
    protected $table = "ms_list_stok";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'serial_number',
        'imei',
        'id_produk',
        'id_gudang_last',
        'id_gudang_first',
        'is_used',
        'use_date',
        'create_date',
        'is_transfer',
        'id_package',
        'is_repair',
        'is_gone',
    ];

    public function produk()
    {
        return $this->hasOne(ProdukMaster::class, 'id', 'id_produk')->withDefault([
            'model' => ''
        ]);
    }

    public function hb()
    {
        return $this->hasOne(HBTerminal::class, 'sn', 'serial_number')->withDefault([
            'payment_1' => null,
            'payment_2' => null,
            'created_date' => null
        ]);
    }
}
