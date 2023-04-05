<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CountryMaster extends Model
{
    use HasFactory;

    protected $table = "country_master";

    protected $fillable = ['country_name', 'country_code', 'nationality', 'user_id', 'active', 'favorite', 'image'];

    protected $primaryKey = 'country_id';

    public $timestamps = false;

    public function cities(){
        return $this->hasMany(CityMaster::class,'country_id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($country) {
            $country->user_id = auth()->id();
        });
    }
}
