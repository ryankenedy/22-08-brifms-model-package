<?php

namespace App\Models\MM;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AidMaster extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "master_aid";
    protected $primaryKey = 'aid_id';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'aid_id',
        'aid',
        'principle_id',
        'tac_denial',
        'tac_online',
        'tac_default',
        'terminal_floor_limit',
        'ddol',
        'ttdol',
        'merchant_force_online',
        'pin_by_pass',
        'velocity_check',
        'target_percentage',
        'max_target_percentage',
        'threshold_limit',
        'issuer_code',
        'cvm_limit',
        'term_capability',
        'addt_term_capability',
        'clss_trx_limit',
        'curr_code',
    ];

    public function getActionAttribute($value)
    {
        return [
            'rid' => [
                'isCan' => request()->user()->hasPermission('master-rid.read'),
                'link' => route('rid.index',['issuer' => $this->issuer, 'aid' => $this]),
            ],
            'edit' => [
                'isCan' => request()->user()->hasPermission('master-aid.update'),
                'link' => route('aid.edit',['issuer' => $this->issuer, 'aid' => $this]),
            ],
            'delete' => [
                'isCan' => request()->user()->hasPermission('master-aid.delete'),
                'link' => route('aid.destroy',['issuer' => $this->issuer, 'aid' => $this]),
            ]
        ];
    }

    public function rids()
    {
        return $this->hasMany(RidMaster::class, 'aid_id', 'aid_id');
    }

    public function issuer()
    {
        return $this->hasOne(IssuerMaster::class, 'issuer_code','issuer_code')->withDefault([
            'issuer_code' => null,
            'issuer_name' => null
        ]);
    }

    public function principle()
    {
        return $this->hasOne(PrincipleMaster::class, 'principle_id','principle_id')->withDefault([
            'principle_name' => null
        ]);
    }
}
