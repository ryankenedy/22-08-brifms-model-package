<?php

namespace App\Models\MS;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServicePoint extends Model
{
    use HasFactory;

    protected $connection = 'mysql_ms';
    protected $table = "ms_service_point";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'address',
        'pic',
        'no_tlp',
        'id_area',
        'id_city',
        'id_group',
        'is_active',
        'longitude',
        'latitude',
        'id_kategori',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}

