<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Reward extends Model
{
    protected $table = 'rewards';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid',
        'name',
        'name_e',
        'description',
        'description_e',
        'image',
        'quantity',
        'likelihood',
    ];

    protected $hidden = [
        'id',
        'quantity',
        'likelihood',
        'created_at',
        'updated_at',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uid = Str::uuid();
        });
    }
}
