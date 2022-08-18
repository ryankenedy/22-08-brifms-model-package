<?php

namespace App\Models\MM;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BinRangeMaster extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "master_bin_range";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'acquiring_code',
        'name',
        'bin_range1',
        'bin_range2',
        'is_on_us',
        'is_kredit',
        'category',
        'nii',
        'created_date',
    ];

    public function getActionAttribute($value)
    {
        return [
            'edit' => [
                'isCan' => Auth::user()->hasPermission('master-bin-range.update'),
                'link' => route('bin-range.edit',[
                    'issuer'    => $this->acquiring->issuer, 
                    'acquiring' => $this->acquiring,
                    'bin_range' => $this
                ]),
            ],
            'delete' => [
                'isCan' => Auth::user()->hasPermission('master-bin-range.delete'),
                'link' => route('bin-range.destroy',[
                    'issuer'    => $this->acquiring->issuer, 
                    'acquiring' => $this->acquiring, 
                    'bin_range' => $this
                ])
            ]
        ];
    }

    public function acquiring()
    {
        return $this->hasOne(AcquiringMaster::class, 'acquiring_code','acquiring_code')->withDefault([
            'acquiring_code' => null,
            'acquiring_name' => null
        ]);
    }
}
