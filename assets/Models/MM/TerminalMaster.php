<?php

namespace App\Models\MM;

use App\Models\MS\StokMaster;
use App\Models\MS\SubTiket;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TerminalMaster extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "master_terminal";
    protected $primaryKey = 'id_terminal';
    public $timestamps = false;

    protected $fillable = [
        'terminal_store_code',
        'terminal_stok_id',
        'terminal_profile_code',
        'terminal_created_date',
        'terminal_void_password',
        'terminal_settlement_password',
        'terminal_function_password',
        'terminal_sale_completion_password',
        'terminal_card_verif_password',
        'terminal_dvc_login',
        'terminal_qr_password',
        'terminal_man_key_in_password',
        'status',
        'force_reset',
        'is_clear_batch',
        'is_copy',
        'version',
        'version_feature',
        'log',
        'request_notes',
        'last_get_profile'
    ];

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($model) {
            $model->helpServicePivots()->delete();
            $model->featurePivots()->delete();
            $model->tids()->delete();
        });
    }

    public function getActionAttribute($value)
    {
        return [
            'detail' => [
                'isCan' => request()->user()->hasPermission('profile-terminal.read') && false,
                'link'  => route('terminal.show',[
                    'terminal'     => $this
                ]),
            ],
            'edit' => [
                'isCan' => request()->user()->hasPermission('profile-terminal.update'),
                'link'  => route('terminal.edit',[
                    'terminal'     => $this,
                ]),
            ],
            'delete' => [
                'isCan' => request()->user()->hasPermission('profile-terminal.delete'),
                'link'  => route('terminal.destroy',[
                    'terminal'     => $this,
                ])
            ],
            'refresh' => [
                'isCan' => request()->user()->hasPermission('profile-terminal-refresh.update'),
                'link' => route('terminal.refresh',[
                    'terminal' => $this
                ])
            ]
        ];
    }

    public function stok()
    {
        return $this->hasOne(StokMaster::class, 'id', 'terminal_stok_id')->withDefault([
            'serial_number' => null
        ]);
    }

    public function store()
    {
        return $this->hasOne(StoreMaster::class, 'store_code', 'terminal_store_code')->withDefault([
            'store_name' => '',
            'store_code' => '',
        ]);
    }

    public function featurePivots()
    {
        return $this->hasMany(TerminalFeature::class, 'poi', 'id_terminal');
    }

    public function features()
    {
        return $this->belongsToMany(
            FeatureMaster::class, 
            'master_terminal_features', 
            'poi',
            'features_code', 
            'id_terminal',
            'code'
        );
    }

    public function helpServicePivots()
    {
        return $this->hasMany(TerminalHelpService::class, 'poi', 'id_terminal');
    }

    public function helpServices()
    {
        return $this->belongsToMany(
            HelpServiceMaster::class, 
            'master_terminal_help', 
            'poi',
            'service_code', 
            'id_terminal',
            'code'
        );
    }

    public function mid()
    {
        return $this->hasOne(StoreMID::class, 'mid_store_code', 'terminal_store_code');
    }

    public function tid()
    {
        return $this->hasOne(TerminalTID::class, 'tid_poi', 'id_terminal');
    }

    public function tids()
    {
        return $this->hasMany(TerminalTID::class, 'tid_poi', 'id_terminal'); 
    }

    public function profile()
    {
        return $this->hasOne(ProfileMaster::class, 'profile_code', 'terminal_profile_code')->withDefault([
            'profile_name' => null
        ]);
    }

    public function tiketInstalasi()
    {
        return $this->hasOne(SubTiket::class, 'poi_capture', 'id_terminal')->whereIn('id_kategori', [1,2])->orderby('created_at', 'desc')->withDefault([
            'id_sub_tiket' => null,
            'done'  => false
        ]);
    }
}
