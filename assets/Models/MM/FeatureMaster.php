<?php

namespace App\Models\MM;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeatureMaster extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "master_feature";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'feature_key',
        'code',
        'name',
        'is_active',
        'version',
        'created_at',
    ];

    public function getGenerateCodeAttribute($value)
    {
        $code = IdGenerator::generate(['table' => $this->table, 'field' => 'code', 'length' => 8, 'prefix' => "FT"]);
        return $code;
    }

    public function getActionAttribute($value)
    {
        return [
            'edit' => [
                'isCan' => Auth::user()->hasPermission('master-feature.update'),
                'link' => route('feature.edit',[
                    'feature' => $this
                ]),
            ],
            'delete' => [
                'isCan' => Auth::user()->hasPermission('master-feature.delete'),
                'link' => route('feature.destroy',[
                    'feature' => $this
                ])
            ]
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
