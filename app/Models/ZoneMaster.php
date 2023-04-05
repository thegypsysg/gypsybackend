<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoneMaster extends Model
{
    use HasFactory;

    protected $table = 'zone_master';

    protected $primaryKey = 'zone_id';

    public $timestamps = false;

    protected $fillable = ['name', 'user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($zone) {
            $zone->user_id = auth()->id();
        });
    }
}
