<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployerJobLocation extends Model
{
    use HasFactory;

    protected $primaryKey = 'ejl_id';

    public $timestamps = false;

    protected $fillable = ['employer_id','country_id', 'city_id', 'town_id', 'zone_id', 'user_id'];

    public function country(){
        return $this->belongsTo(CountryMaster::class, 'country_id');
    }

    public function city(){
        return $this->belongsTo(CityMaster::class, 'city_id');
    }

    public function town(){
        return $this->belongsTo(TownMaster::class, 'town_id');
    }

    public function zone(){
        return $this->belongsTo(ZoneMaster::class, 'zone_id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($jobLocation) {
            $jobLocation->user_id = auth()->id();
        });
    }
}
