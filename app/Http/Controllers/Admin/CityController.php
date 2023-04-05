<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCityRequest;
use App\Http\Requests\UpdateCityRequest;
use App\Models\CityMaster;
use App\Models\CountryMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CityController extends Controller
{
    public function index(){

        $cities = CityMaster::get();

        $countries = CountryMaster::select('country_id', 'country_name')->get();

        return view('pages.cities.manage_cities', compact('cities','countries'));
    }

    public function store(StoreCityRequest $request){
        try{
            
            $attributes = $request->validated();
            
            CityMaster::create($attributes);

            toastr()->success('City Added!');

            return back();

        } catch(\Exception $ex){
            
            Log::error($ex->getMessage());

            toastr()->error('Problem occured!');

            return back();

        }
    }

    public function edit(CityMaster $city){

        $cities = CityMaster::get();

        $countries = CountryMaster::select('country_id', 'country_name')->get();

        return view('pages.cities.manage_cities', compact('cities', 'city', 'countries'));
    }

    public function update(UpdateCityRequest $request, CityMaster $city){
       
        try{
            
            $attributes = $request->validated();
            
            CityMaster::find($city->city_id)->update($attributes);

            toastr()->success('City Updated!');

            return back();

        } catch(\Exception $ex){

            Log::error($ex->getMessage());

            toastr()->success('Problem occured!');

            return back();

        }
    }

    public function destroy(CityMaster $city){

        try{

            $city->delete();

            toastr()->success('City Deleted!');

        } catch (\Exception $ex) {

            Log::error($ex->getMessage());

        }
        
        return back();
    }
}
