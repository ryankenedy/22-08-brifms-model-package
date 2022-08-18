<?php

namespace App\Models\MM;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AcquiringMaster extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "profile_acquiring";
    protected $primaryKey = 'id_acquiring';
    public $timestamps = false;

    protected $fillable = [
        'issuer_code',
        'acquiring_key',
        'acquiring_code',
        'acquiring_name',
        'acquiring_app_package',
        'acquiring_icon_url',
        'acquiring_icon_struk_url',
        'acquiring_pin_config',
        'acquiring_is_active',
        'acquiring_order',
        'acquiring_version',
        'timer_counter',
        'acquiring_reversal_number',
        'timer_schedular',
        'time_clear_batch',
    ];

    protected $casts = [
        'time_clear_batch' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($model) {
            if($model->acquiring_icon_url && Storage::disk('local')->exists($model->acquiring_icon_url)){
                Storage::disk('local')->delete($model->acquiring_icon_url);
            }

            if($model->acquiring_icon_struk_url && Storage::disk('local')->exists($model->acquiring_icon_struk_url)){
                Storage::disk('local')->delete($model->acquiring_icon_struk_url);
            }
        });
    }

    public function getGenerateCodeAttribute($value)
    {
        $code = IdGenerator::generate(['table' => $this->table, 'field' => 'acquiring_code', 'length' => 5, 'prefix' => "AC"]);
        return $code;
    }

    public function getActionAttribute($value)
    {
        return [
            'key' => [
                'isCan' => Auth::user()->hasPermission('master-configure.read'),
                'link' => route('configure.index',['issuer' => $this->issuer, 'acquiring' => $this])
            ],
            'bin_range' => [
                'isCan' => Auth::user()->hasPermission('master-bin-range.read'),
                'link' => route('bin-range.index',['issuer' => $this->issuer, 'acquiring' => $this])
            ],
            'edit' => [
                'isCan' => Auth::user()->hasPermission('master-acquiring.update'),
                'link' => route('acquiring.edit',['issuer' => $this->issuer, 'acquiring' => $this]),
            ],
            'delete' => [
                'isCan' => Auth::user()->hasPermission('master-acquiring.delete'),
                'link' => route('acquiring.destroy',['issuer' => $this->issuer, 'acquiring' => $this])
            ]
        ];
    }

    public function getIconUrlAttribute()
    {
        if($this->acquiring_icon_url && Storage::disk('local')->exists($this->acquiring_icon_url)){
            return url('storage/'.$this->acquiring_icon_url);
        }
        return asset('image/logo_pcs_putih_high.png');
    }

    public function getIconStrukUrlAttribute()
    {
        if($this->acquiring_icon_struk_url && Storage::disk('local')->exists($this->acquiring_icon_struk_url)){
            return url('storage/'.$this->acquiring_icon_struk_url);
        }
        return asset('image/logo_pcs_putih_high.png');
    }

    public function scopeActive($query)
    {
        return $query->where('acquiring_is_active', 1);
    }

    public function issuer()
    {
        return $this->hasOne(IssuerMaster::class, 'issuer_code', 'issuer_code')->withDefault([
            'issuer_code' => null,
            'issuer_name' => null
        ]);
    }

    public function configure()
    {
        return $this->hasOne(ConfigureMaster::class, 'acquiring_code','acquiring_code')->withDefault([
            'ltmk_acq_id' => null
        ]);
    }

    public function binRanges()
    {
        return $this->hasMany(BinRangeMaster::class, 'acquiring_code','acquiring_code');
    }
}
