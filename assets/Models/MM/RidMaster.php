<?php

namespace App\Models\MM;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RidMaster extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "master_rid";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'aid_id',
        'rid',
        'rid_index',
        'modulus',
        'exponent',
        'expiry',
        'hash',
        'algorithm',
        'result',
        'created_date',
    ];

    public function getActionAttribute($value)
    {
        return [
            'edit' => [
                'isCan' => Auth::user()->hasPermission('master-rid.update'),
                'link' => route('rid.edit',[
                    'issuer' => $this->aid->issuer, 
                    'aid' => $this->aid, 
                    'rid' => $this
                ]),
            ],
            'delete' => [
                'isCan' => Auth::user()->hasPermission('master-rid.delete'),
                'link' => route('rid.destroy',[
                    'issuer' => $this->aid->issuer, 
                    'aid' => $this->aid, 
                    'rid' => $this
                ]),
            ]
        ];
    }

    public function aid()
    {
        return $this->hasOne(AidMaster::class, 'aid_id','aid_id')->withDefault([
            'aid_id' => null
        ]);
    }
}
