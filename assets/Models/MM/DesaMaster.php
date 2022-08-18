<?php

namespace App\Models\MM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesaMaster extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "villages";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'district_id',
        'name'
    ];

    public function kecamatan()
    {
        return $this->hasOne(KecamatanMaster::class, 'id','district_id')->withDefault([
            'name' => null
        ]);
    }
}
