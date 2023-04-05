<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TownMaster extends Model
{
    use HasFactory;

    protected $table = 'town_master';

    protected $primaryKey = 'town_id';

    const CREATED_AT = 'date_added';

    const UPDATED_AT = null;

    protected $fillable = ['town_name', 'city_id', 'user_id'];

    public function city(){
        return $this->belongsTo(CityMaster::class, 'city_id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($town) {
            $town->user_id = auth()->id();
        });
    }
}
