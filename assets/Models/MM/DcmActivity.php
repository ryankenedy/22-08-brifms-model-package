<?php

namespace App\Models\MM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DcmActivity extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = "dcm_activity";
    protected $primaryKey = 'activity_id';
    public $timestamps = false;

    protected $fillable = [
        'activity_code',
        'activity_name'
    ];
}
