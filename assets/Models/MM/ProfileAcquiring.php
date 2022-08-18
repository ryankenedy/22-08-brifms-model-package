<?php

namespace App\Models\MM;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileAcquiring extends Model
{
    use HasFactory, ModelTrait;

    protected $connection = 'mysql';
    protected $table = "profile_data";
    protected $primaryKey = 'id_profile';
    public $timestamps = false;

    protected $fillable = [
        'profile_code',
        'acquiring_code'
    ];
}
