<?php

namespace App\Models\MM;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClientMaster extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "master_client";
    protected $primaryKey = 'id_client';
    public $timestamps = false;

    protected $fillable = [
        'company_code',
        'client_code',
        'client_name',
        'client_address',
        'client_village',
        'client_district',
        'client_city',
        'client_state',
        'client_telephone',
        'client_fax',
        'client_pic',
        'client_pic_telephone',
        'client_postal_code',
        'client_created_at',
        'profile_code',
        'log'
    ];

    public function getRouteKeyName()
    {
        return 'client_code';
    }

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($model) {
            $model->featurePivots()->delete();
            $model->helpServicePivots()->delete();
            $model->merchants()->delete();
        });
    }

    public function getActionAttribute($value)
    {
        return [
            'detail' => [
                'isCan' => request()->user()->hasPermission('profile-client.read'),
                'link' => route('client.show',[
                    'client' => $this
                ]),
            ],
            'edit' => [
                'isCan' => request()->user()->hasPermission('profile-client.update'),
                'link' => route('client.edit',[
                    'client' => $this
                ]),
            ],
            'delete' => [
                'isCan' => request()->user()->hasPermission('profile-client.delete'),
                'link' => route('client.destroy',[
                    'client' => $this
                ])
            ],
            'refresh' => [
                'isCan' => request()->user()->hasPermission('profile-client-refresh.update'),
                'link' => route('client.refresh',[
                    'client' => $this
                ])
            ]
        ];
    }

    public function getGenerateCodeAttribute($value)
    {
        $code = IdGenerator::generate(['table' => $this->table, 'field' => 'client_code', 'length' => 5, 'prefix' => "CL"]);
        return $code;
    }

    public function profile()
    {
        return $this->hasOne(ProfileMaster::class,'profile_code', 'profile_code')->withDefault([
            'profile_name' => null,
            'profile_code' => null
        ]);
    }

    public function company()
    {
        return $this->hasOne(CompanyMaster::class,'company_code', 'company_code')->withDefault([
            'company_name' => null,
            'company_name' => null
        ]);
    }

    public function featurePivots()
    {
        return $this->hasMany(ClientFeature::class, 'client_code', 'client_code');
    }

    public function features()
    {
        return $this->belongsToMany(
            FeatureMaster::class, 
            'master_client_features', 
            'client_code',
            'features_code', 
            'client_code',
            'code'
        );
    }

    public function helpServicePivots()
    {
        return $this->hasMany(ClientHelpService::class, 'client_code', 'client_code');
    }

    public function helpServices()
    {
        return $this->belongsToMany(
            HelpServiceMaster::class, 
            'master_client_help', 
            'client_code',
            'service_code', 
            'client_code',
            'code'
        );
    }

    public function merchants()
    {
        return $this->hasMany(MerchantMaster::class, 'client_code', 'client_code');
    }
}
