<?php

namespace App\Models\MM;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StoreMaster extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "master_store";
    protected $primaryKey = 'id_store';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'merchant_code',
        'store_code',
        'store_name',
        'store_address',
        'store_address2',
        'store_postal_code',
        'store_telephone',
        'store_pic',
        'store_profile_code',
        'store_void_password',
        'store_settlement_password',
        'store_dvc_login',
        'store_function_password',
        'store_sale_completion_password',
        'store_card_verif_password',
        'store_qr_password',
        'store_man_key_in_password',
        'province_code',
        'kabupaten_code',
        'kelurahan_code',
        'village_code',
        'kanwil_code',
        'area_code',
        'kcp_code',
        'store_version',
        'store_log',
        'store_created_at',
    ];

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($model) {
            $model->helpServicePivots()->delete();
            $model->terminals()->delete();
            $model->mids()->delete();
        });
    }

    public function getRouteKeyName()
    {
        return 'store_code';
    }

    public function getActionAttribute($value)
    {
        return [
            'detail' => [
                'isCan' => request()->user()->hasPermission('profile-store.read'),
                'link'  => route('store.show',[
                    'store'     => $this
                ]),
            ],
            'edit' => [
                'isCan' => request()->user()->hasPermission('profile-store.update'),
                'link'  => route('store.edit',[
                    'store'     => $this,
                ]),
            ],
            'delete' => [
                'isCan' => request()->user()->hasPermission('profile-store.delete'),
                'link'  => route('store.destroy',[
                    'store'     => $this,
                ])
            ],
            'refresh' => [
                'isCan' => request()->user()->hasPermission('profile-store-refresh.update'),
                'link' => route('store.refresh',[
                    'store' => $this
                ])
            ]
        ];
    }

    public function getCode($prefix)
    {
        $length = strlen($prefix)+2;
        $config = [
            'table' => $this->table, 
            'field' => 'store_code', 
            'length' => $length, 
            'prefix' => $prefix, 
            'reset_on_prefix_change' => true
        ];
        $code = IdGenerator::generate($config);
        return $code;
    }

    public function helpServicePivots()
    {
        return $this->hasMany(StoreHelpService::class, 'store_code', 'store_code');
    }

    public function helpServices()
    {
        return $this->belongsToMany(
            HelpServiceMaster::class, 
            'master_store_help', 
            'store_code',
            'service_code', 
            'store_code',
            'code'
        );
    }

    public function mids()
    {
        return $this->hasMany(StoreMID::class, 'mid_store_code', 'store_code'); 
    }

    public function merchant()
    {
        return $this->hasOne(MerchantMaster::class, 'merchant_code', 'merchant_code')->withDefault([
            'merchant_name' => '',
            'merchant_code' => '',
        ]);
    }

    public function profile()
    {
        return $this->hasOne(ProfileMaster::class, 'profile_code', 'store_profile_code')->withDefault([
            'profile_code' => null,
            'profile_name' => null
        ]);
    }

    public function kanwil()
    {
        return $this->hasOne(KanwilMaster::class, 'code','kanwil_code')->withDefault([
            'name' => ''
        ]);
    }

    public function area()
    {
        return $this->hasOne(AreaMaster::class, 'code','area_code')->withDefault([
            'name' => ''
        ]);
    }

    public function kcp()
    {
        return $this->hasOne(KcpMaster::class, 'code','kcp_code')->withDefault([
            'name' => ''
        ]);
    }

    public function provinsi()
    {
        return $this->hasOne(ProvinsiMaster::class, 'id', 'province_code')->withDefault([
            'name' => ''
        ]);
    }

    public function kabupaten()
    {
        return $this->hasOne(KabKotMaster::class, 'id', 'kabupaten_code')->withDefault([
            'name' => ''
        ]);
    }

    public function terminals()
    {
        return $this->hasMany(TerminalMaster::class, 'terminal_store_code', 'store_code');
    }
}
