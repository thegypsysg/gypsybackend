<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppGroup extends Model
{
    use HasFactory;

    protected $table = 'app_group_master';

    protected $guarded = ['app_group_id'];

    protected $primaryKey = 'app_group_id';

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($app_group) {
            $app_group->user_id = auth()->id();
        });
    }
}
