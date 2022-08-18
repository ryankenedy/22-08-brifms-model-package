<?php

namespace App\Models\MM;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TerminalFeature extends Model
{
    use HasFactory, ModelTrait;

    protected $connection = 'mysql';
    protected $table = "master_terminal_features";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'poi',
        'acquiring_code',
        'features_code',
        'mid',
        'tid',
        'code',
        'nii',
        'other1',
        'active',
        'tag',
        'feature_order'
    ];
}
