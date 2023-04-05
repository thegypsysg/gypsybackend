<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployerJobLocationRequest;
use App\Http\Requests\UpdateEmployerContactRequest;
use App\Http\Requests\UpdateEmployerJobLocationRequest;
use App\Models\CityMaster;
use App\Models\CountryMaster;
use App\Models\EmployerJobLocation;
use App\Models\EmployerMaster;
use App\Models\TownMaster;
use App\Models\ZoneMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmployerJobLocationController extends Controller
{
    public function show($id){
        
        $employer = EmployerMaster::with('jobLocations')->find($id);

        $countries = CountryMaster::select('country_id', 'country_name')->get();

        $cities = CityMaster::select('city_id', 'city_name')->get();
        
        $zones = ZoneMaster::select('zone_id', 'name')->get();

        $towns = TownMaster::select('town_id', 'town_name')->get();

        return view('pages.employers.job_locations', compact('employer', 'countries', 'cities', 'zones', 'towns'));
    }

    public function store(StoreEmployerJobLocationRequest $request){
        try{
            
            $attributes = $request->validated();

            $data = [
                'country_id' => CountryMaster::where('country_name', $attributes['country_id'])->select('country_id')->first()->country_id,
                'city_id' => CityMaster::where('city_name', $attributes['city_id'])->select('city_id')->first()->city_id,
                'town_id' => TownMaster::where('town_name', $attributes['town_id'])->select('town_id')->first()->town_id,
                'zone_id' => ZoneMaster::where('name', $attributes['zone_id'])->select('zone_id')->first()->zone_id,
                'employer_id' => $attributes['employer_id']
            ];

            EmployerJobLocation::create($data);

            toastr()->success('Location Added!');

            return back();

        } catch(\Exception $ex){
            
            Log::error($ex->getMessage());

            toastr()->error('Problem occured!');

            return back();

        }
    }

    public function edit(EmployerJobLocation $employerJobLocation){

        $employer = EmployerMaster::with('contacts')->find($employerJobLocation->employer_id);

        $countries = CountryMaster::select('country_id', 'country_name')->get();

        $cities = CityMaster::select('city_id', 'city_name')->get();
        
        $zones = ZoneMaster::select('zone_id', 'name')->get();

        $towns = TownMaster::select('town_id', 'town_name')->get();

        return view('pages.employers.job_locations', compact('employer', 'employerJobLocation','countries', 'cities', 'zones', 'towns'));
    }

    public function update(UpdateEmployerJobLocationRequest $request, EmployerJobLocation $employerJobLocation){
       
        try{
            
            $attributes = $request->validated();

            $data = [
                'country_id' => CountryMaster::where('country_name', $attributes['country_id'])->select('country_id')->first()->country_id,
                'city_id' => CityMaster::where('city_name', $attributes['city_id'])->select('city_id')->first()->city_id,
                'town_id' => TownMaster::where('town_name', $attributes['town_id'])->select('town_id')->first()->town_id,
                'zone_id' => ZoneMaster::where('name', $attributes['zone_id'])->select('zone_id')->first()->zone_id,
                'employer_id' => $attributes['employer_id']
            ];
            
            EmployerJobLocation::find($employerJobLocation->ejl_id)->update($data);

            toastr()->success('Contact Updated!');

            return redirect()->route('employer-job-locations.show', $employerJobLocation->ejl_id);

        } catch(\Exception $ex){

            Log::error($ex->getMessage());

            toastr()->error('Problem occured!');

            return back();

        }
    }

    public function destroy(EmployerJobLocation $employerJobLocation){

        try{
           
            $employerJobLocation->delete();

            toastr()->success('Contact Deleted!');

        } catch (\Exception $ex) {

            Log::error($ex->getMessage());

        }
        
        return back();
    }
}
