<?php

namespace App\Http\Controllers;

use App\Models\CityMaster;
use App\Models\CountryMaster;
use App\Models\TownMaster;
use Illuminate\Http\Request;

class DynamicOptionController extends Controller
{
    public function getCities($country){

        if(intval($country)){
            $column = 'country_id';
        } else {
            $column = 'country_name';
        }

        $cities = CountryMaster::with('Cities')->where($column, $country)->select('country_id')->first();

        return view('partials.cities', compact('cities'));
        
    }

    public function getTowns( $city){

        $towns = CityMaster::with('towns')->where('city_name', $city)->select('city_id')->first();

        return view('partials.towns', compact('towns'));
        
    }
}
