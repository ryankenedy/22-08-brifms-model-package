<?php

namespace App\Models\MS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukMaster extends Model
{
    use HasFactory;

    protected $connection = 'mysql_ms';
    protected $table = "ms_produk";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id_brand',
        'model',
    ];

    public function brand()
    {
        return $this->hasOne(BrandMaster::class, 'id', 'id_brand')->withDefault([
            'name' => '',
        ]);
    }
}
