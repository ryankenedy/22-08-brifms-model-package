<?php

namespace App\Models\HB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HBTerminal extends Model
{
    use HasFactory;

    protected $connection = 'mysql_hb';
    protected $table = "heartbeat_terminal";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $appends = ['active'];
    
    public function getActiveAttribute()
    {
        return $this->created_date > date('Y-m-d H:i:s', strtotime('-300 minutes'));
    }
}
