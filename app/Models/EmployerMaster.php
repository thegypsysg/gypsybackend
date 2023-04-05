<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployerMaster extends Model
{
    use HasFactory;

    protected $table = 'employer_master';

    protected $primaryKey = 'employer_id';

    public $timestamps = false;

    protected $fillable = ['employer_name', 'country_id', 'city_id', 'hs_id', 'town_id', 'zone_id', 'active', 'featured', 'website', 'telephone', 'postal_code', 'address','image'];

    public function country(){
        return $this->belongsTo(CountryMaster::class, 'country_id');
    }

    public function city(){
        return $this->belongsTo(CityMaster::class, 'city_id');
    }

    public function town(){
        return $this->belongsTo(TownMaster::class, 'town_id');
    }

    public function type(){
        return $this->belongsTo(HealthCareSetting::class, 'hs_id');
    }

    public function contacts(){
        return $this->hasMany(EmployerContact::class, 'employer_id');
    }

    public function jobLocations(){
        return $this->hasMany(EmployerJobLocation::class, 'employer_id');
    }
}
