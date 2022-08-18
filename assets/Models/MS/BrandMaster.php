<?php

namespace App\Models\MS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandMaster extends Model
{
    use HasFactory;

    protected $connection = 'mysql_ms';
    protected $table = "ms_brand";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id_supplier',
        'name',
    ];
}
