<?php

namespace App\Models\MM;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class IssuerMaster extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "master_issuer";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'issuer_code',
        'issuer_key',
        'issuer_package',
        'issuer_name',
        'issuer_is_active',
        'fallback_is_active',
        'pin_length',
        'pin_length_min',
        'nii',
        'url_server',
        'port',
        'endpoint_id',
        'emv_debit_on',
        'emv_debit_off',
        'emv_credit_on',
        'emv_credit_off',
        'created_date',
        'updated_date',
    ];

    public function getGenerateCodeAttribute($value)
    {
        $code = IdGenerator::generate(['table' => $this->table, 'field' => 'issuer_code', 'length' => 8, 'prefix' => "IS"]);
        return $code;
    }

    public function getActionAttribute($value)
    {
        return [
            'acquiring' => [
                'isCan' => Auth::user()->hasPermission('master-acquiring.read'),
                'link' => route('acquiring.index',$this)
            ],
            'edit' => [
                'isCan' => Auth::user()->hasPermission('master-issuer.update'),
                'link' => route('issuer.edit',$this),
            ],
            'delete' => [
                'isCan' => Auth::user()->hasPermission('master-issuer.delete'),
                'link' => route('issuer.destroy',$this)
            ]
        ];
    }

    public function endpoint()
    {
        return $this->hasOne(EndPointMaster::class,'id','endpoint_id')->withDefault([
            'name' => null
        ]);
    }

    public function acquirings()
    {
        return $this->hasMany(AcquiringMaster::class, 'issuer_code','issuer_code');
    }

    public function niis()
    {
        return $this->hasMany(NiiMaster::class, 'issuer_code','issuer_code');
    }

    public function aids()
    {
        return $this->hasMany(AidMaster::class, 'issuer_code','issuer_code');
    }
    
}
