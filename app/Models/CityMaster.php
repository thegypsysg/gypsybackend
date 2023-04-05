<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CityMaster extends Model
{
    use HasFactory;

    protected $table = 'city_master';

    protected $primaryKey = 'city_id';

    public $timestamps = false;

    protected $fillable = ['city_name', 'country_id', 'user_id'];

    public function country(){
        return $this->belongsTo(CountryMaster::class, 'country_id');
    }

    public function towns(){
        return $this->hasMany(TownMaster::class,'city_id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($city) {
            $city->user_id = auth()->id();
        });
    }
}
