<?php

namespace App\Models\MM;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MerchantMaster extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "master_merchant";
    protected $primaryKey = 'id_merchant';
    public $timestamps = false;

    protected $fillable = [
        'client_code',
        'company_code',
        'profile_code',
        'merchant_name',
        'merchant_code',
        'merchant_criteria',
        'merchant_address',
        'merchant_telephone',
        'merchant_pic',
        'merchant_void_password',
        'merchant_is_print',
        'merchant_is_duplicate',
        'merchant_is_enter',
        'merchant_is_autosettlement',
        'merchant_settlement_max',
        'merchant_settlement_password',
        'merchant_settlement_notify',
        'merchant_function_pin',
        'merchant_dvc_login',
        'merchant_function_password',
        'merchant_sale_completion_password',
        'merchant_card_verif_password',
        'merchant_qr_password',
        'merchant_man_key_in_password',
        'merchant_logo',
        'merchant_sales_logo',
        'merchant_main_page',
        'merchant_created_at',
        'version',
        'log'
    ];

    protected $hidden = [
        'merchant_void_password',
        'merchant_settlement_password',
        'merchant_dvc_login',
        'merchant_function_password',
        'merchant_sale_completion_password',
        'merchant_card_verif_password',
        'merchant_qr_password',
    ];

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($model) {
            $model->featurePivots()->delete();
            $model->helpServicePivots()->delete();
            $model->stores()->delete();

            if($model->merchant_logo && Storage::disk('local')->exists($model->merchant_logo)){
                Storage::disk('local')->delete($model->merchant_logo);
            }

            if($model->merchant_sales_logo && Storage::disk('local')->exists($model->merchant_sales_logo)){
                Storage::disk('local')->delete($model->merchant_sales_logo);
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'merchant_code';
    }

    public function getLogoUrlAttribute()
    {
        if($this->merchant_logo && Storage::disk('local')->exists($this->merchant_logo)){
            return url('storage/'.$this->merchant_logo);
        }
        return asset('image/logo_pcs_putih_high.png');
    }

    public function getLogoSalesUrlAttribute()
    {
        if($this->merchant_sales_logo && Storage::disk('local')->exists($this->merchant_sales_logo)){
            return url('storage/'.$this->merchant_sales_logo);
        }
        return asset('image/logo_pcs_putih_high.png');
    }

    public function getActionAttribute($value)
    {
        return [
            'detail' => [
                'isCan' => request()->user()->hasPermission('profile-merchant.read'),
                'link' => route('merchant.show',[
                    'merchant' => $this
                ]),
            ],
            'edit' => [
                'isCan' => request()->user()->hasPermission('profile-merchant.update'),
                'link' => route('merchant.edit',[
                    'merchant' => $this
                ]),
            ],
            'delete' => [
                'isCan' => request()->user()->hasPermission('profile-merchant.delete'),
                'link' => route('merchant.destroy',[
                    'merchant' => $this
                ])
            ],
            'refresh' => [
                'isCan' => request()->user()->hasPermission('profile-merchant-refresh.update'),
                'link' => route('merchant.refresh',[
                    'merchant' => $this
                ])
            ]
        ];
    }

    public function getCode($prefix)
    {
        $config = [
            'table' => $this->table, 
            'field' => 'merchant_code', 
            'length' => 9, 
            'prefix' => $prefix, 
            'reset_on_prefix_change' => true
        ];
        $code = IdGenerator::generate($config);
        return $code;
    }

    public function client()
    {
        return $this->hasOne(ClientMaster::class, 'client_code', 'client_code')->withDefault([
            'client_code' => null,
            'client_name' => null
        ]);
    }

    public function profile()
    {
        return $this->hasOne(ProfileMaster::class,'profile_code', 'profile_code')->withDefault([
            'profile_code' => null,
            'profile_name' => null
        ]);
    }

    public function featurePivots()
    {
        return $this->hasMany(MerchantFeature::class, 'merchant_code', 'merchant_code');
    }

    public function features()
    {
        return $this->belongsToMany(
            FeatureMaster::class, 
            'master_merchant_features', 
            'merchant_code',
            'features_code', 
            'merchant_code',
            'code'
        );
    }

    public function helpServicePivots()
    {
        return $this->hasMany(MerchantHelpService::class, 'merchant_code', 'merchant_code');
    }

    public function helpServices()
    {
        return $this->belongsToMany(
            HelpServiceMaster::class, 
            'master_merchant_help', 
            'merchant_code',
            'service_code', 
            'merchant_code',
            'code'
        );
    }

    public function stores()
    {
        return $this->hasMany(StoreMaster::class, 'merchant_code', 'merchant_code');
    }
}
