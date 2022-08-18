<?php

namespace App\Models\HB;

use App\Models\MM\StoreMID;
use App\Models\MM\TerminalTID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HBSecondary extends Model
{
    use HasFactory;

    protected $connection = 'mysql_hb';
    protected $table = "heartbeat_secondary";
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function tid()
    {
        return $this->hasOne(TerminalTID::class, 'tid_poi', 'poi')->withDefault([
            'tid_tid' => null
        ]);
    }

    public function mid()
    {
        return $this->hasOne(StoreMID::class, 'mid_store_code', 'store_code')->withDefault([
            'mid_mid' => null
        ]);
    }
}
