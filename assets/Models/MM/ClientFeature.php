<?php

namespace App\Models\MM;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientFeature extends Model
{
    use HasFactory, ModelTrait;

    protected $connection = 'mysql';
    protected $table = "master_client_features";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'client_feature',
        'acquiring_code',
        'features_code',
    ];
}
