<?php

namespace App\Models\MM;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyMaster extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "master_company";
    protected $primaryKey = 'id_company';
    public $timestamps = false;

    public const IDENTIFY_TYPES = [
        1 => "KTP",
        2 => "SIM",
        3 => "Password",
    ];

    public function getRouteKeyName()
    {
        return 'company_code';
    }

    protected $fillable = [
        'person_fullname',
        'person_address',
        'person_village',
        'person_district',
        'person_city',
        'person_state',
        'person_postal_code',
        'person_country',
        'person_email',
        'person_telephone',
        'person_phone',
        'person_type_id',
        'person_no_identity',
        'is_same',
        'company_code',
        'company_name',
        'company_address',
        'company_village',
        'company_district',
        'company_city',
        'company_state',
        'company_telephone',
        'company_fax',
        'company_postal_code',
        'company_created_at',
        'profile_code',
        'log'
    ];

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($model) {
            $model->featurePivots()->delete();
            $model->helpServicePivots()->delete();
            $model->clients()->delete();
        });
    }

    public function getActionAttribute($value)
    {
        return [
            'detail' => [
                'isCan' => request()->user()->hasPermission('profile-company.read'),
                'link' => route('company.show',[
                    'company' => $this
                ]),
            ],
            'edit' => [
                'isCan' => request()->user()->hasPermission('profile-company.update'),
                'link' => route('company.edit',[
                    'company' => $this
                ]),
            ],
            'delete' => [
                'isCan' => request()->user()->hasPermission('profile-company.delete'),
                'link' => route('company.destroy',[
                    'company' => $this
                ])
            ],
            'refresh' => [
                'isCan' => request()->user()->hasPermission('profile-company-refresh.update'),
                'link' => route('company.refresh',[
                    'company' => $this
                ])
            ]
        ];
    }

    public function getGenerateCodeAttribute($value)
    {
        $code = IdGenerator::generate(['table' => $this->table, 'field' => 'company_code', 'length' => 5, 'prefix' => "C"]);
        return $code;
    }

    public function getIdentifyNameAttribute($value)
    {
        if(array_key_exists($this->person_type_id, self::IDENTIFY_TYPES))
        {
            return self::IDENTIFY_TYPES[$this->person_type_id];
        }
        return '';
    }

    public function featurePivots()
    {
        return $this->hasMany(CompanyFeature::class, 'company_code', 'company_code');
    }

    public function features()
    {
        return $this->belongsToMany(
            FeatureMaster::class, 
            'master_company_features', 
            'company_code',
            'features_code', 
            'company_code',
            'code'
        );
    }

    public function helpServicePivots()
    {
        return $this->hasMany(CompanyHelpService::class, 'company_code', 'company_code');
    }

    public function helpServices()
    {
        return $this->belongsToMany(
            HelpServiceMaster::class, 
            'master_company_help', 
            'company_code',
            'service_code', 
            'company_code',
            'code'
        );
    }

    public function profile()
    {
        return $this->hasOne(ProfileMaster::class,'profile_code', 'profile_code')->withDefault([
            'profile_name' => null,
            'profile_code' => null
        ]);
    }

    public function clients()
    {
        return $this->hasMany(ClientMaster::class, 'company_code', 'company_code');
    }
}

