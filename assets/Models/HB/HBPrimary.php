<?php

namespace App\Models\HB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HBPrimary extends Model
{
    use HasFactory;

    protected $connection = 'mysql_hb';
    protected $table = "heartbeat_primary";
    protected $primaryKey = 'id';
    public $timestamps = false;
}
