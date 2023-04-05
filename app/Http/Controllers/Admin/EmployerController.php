<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployerRequest;
use App\Http\Requests\UpdateEmployerRequest;
use App\Models\CityMaster;
use App\Models\CountryMaster;
use App\Models\EmployerMaster;
use App\Models\HealthCareSetting;
use App\Models\TownMaster;
use App\Models\ZoneMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class EmployerController extends Controller
{
    public function index(){

        $employers = EmployerMaster::get();

        $types = HealthCareSetting::select('hs_id', 'settings_name')->get();

        $countries = CountryMaster::select('country_id', 'country_name')->get();

        $cities = CityMaster::select('city_id', 'city_name')->get();
        
        $zones = ZoneMaster::select('zone_id', 'name')->get();

        $towns = TownMaster::select('town_id', 'town_name')->get();

        return view('pages.employers.manage_employers', compact('employers', 'countries', 'cities', 'towns', 'types','zones'));
    }

    public function store(StoreEmployerRequest $request){
        try{
            
            $attributes = $request->validated();
            
            EmployerMaster::create($attributes);

            toastr()->success('Employer Added!');

            return back();

        } catch(\Exception $ex){
            
            Log::error($ex->getMessage());

            toastr()->error('Problem occured!');

            return back();

        }
    }

    public function edit(EmployerMaster $employer){

        $employers = EmployerMaster::get();

        $types = HealthCareSetting::select('hs_id', 'settings_name')->get();

        $countries = CountryMaster::select('country_id', 'country_name')->get();

        $cities = CityMaster::select('city_id', 'city_name')->get();
        
        $zones = ZoneMaster::select('zone_id', 'name')->get();

        $towns = TownMaster::select('town_id', 'town_name')->get();

        return view('pages.employers.manage_employers', compact('employers', 'employer', 'types', 'countries', 'cities', 'zones', 'towns'));
    }

    public function update(UpdateEmployerRequest $request, EmployerMaster $employer){
       
        try{
            
            $attributes = $request->validated();
            
            EmployerMaster::find($employer->employer_id)->update($attributes);

            toastr()->success('Employer Updated!');

            return redirect()->route('employers.index');

        } catch(\Exception $ex){

            Log::error($ex->getMessage());

            toastr()->success('Problem occured!');

            return back();

        }
    }

    public function destroy(EmployerMaster $employer){

        try{

            $employer->delete();

            toastr()->success('Employer Deleted!');

        } catch (\Exception $ex) {

            Log::error($ex->getMessage());

        }
        
        return back();
    }

    public function updateActive(Request $request, EmployerMaster $employer){
        try{
            
            EmployerMaster::find($employer->employer_id)->update(['active'=>$request->active]);

            $message = "Employer activated!";

            if($request->active == 'N'):
                $message = "Employer deactivated!";
            endif;

            return response()->json([
                'message' => $message
            ]);

        } catch(\Exception $ex){

            Log::error($ex->getMessage());

            return response()->json([
                'message' => 'Problem occured'
            ]);

        }
    }

    public function updateFeatured(Request $request, EmployerMaster $employer){
        try{
           
            EmployerMaster::find($employer->employer_id)->update(['featured'=>$request->featured]);
            
            $message = 'Employer added to featured';
            
            if($request->featured == 'N'):
                $message = "Employer removed from featured!";
            endif;

            return response()->json([
                'message' => $message
            ]);

        } catch(\Exception $ex){

            Log::error($ex->getMessage());

            return response()->json([
                'message' => 'Problem occured'
            ]);

        }
    }

    public function mainInfo(Request $request, EmployerMaster $employer){
       
        $types = HealthCareSetting::select('hs_id', 'settings_name')->get();

        $countries = CountryMaster::select('country_id', 'country_name')->get();

        $cities = CityMaster::select('city_id', 'city_name')->get();
        
        $zones = ZoneMaster::select('zone_id', 'name')->get();

        $towns = TownMaster::select('town_id', 'town_name')->get();

        return view('pages.employers.main_info', compact('employer', 'types', 'countries', 'cities', 'zones', 'towns'));
    }

    public function uploadImage(Request $request)
    {

        try {
            if ($request->hasFile('image')) {

                $image_name = uploadImage($request->image, 'public/Employers');
                $fileName = $image_name;

                // Move the file to the public directory
                $request->image->move(public_path('storage/Employers'), $fileName);

                // Get the URL for the public file
                $publicUrl = asset('images/' . $fileName);
               
                $filename = str_replace('public/', '', $image_name);
                $EmployerMaster = EmployerMaster::find($request->employee_id);

                if ($EmployerMaster->image != null && file_exists(Storage::path('public/Employers/' . $EmployerMaster->image))) {
                    Storage::delete('public/Employers/' . $EmployerMaster->image);
                }

                $EmployerMaster->update([
                    'image' => $filename
                ]);

                return response()->json([
                    'data' => asset('storage/' . $filename),
                    'message' => 'Image uploaded'
                ]);
            }
        } catch (\Exception $ex) {

            Log::error($ex->getMessage());

            return response()->json([
                'message' => 'Problem occured'
            ]);
        }
    }

    public function imageRemove($id){
        try {
            $EmployerMaster = EmployerMaster::find($id);
            if($EmployerMaster){
                if ($EmployerMaster->image != null && file_exists(Storage::path('public/Employers/' . $EmployerMaster->image))) {
                    Storage::delete('public/Employers/' . $EmployerMaster->image);
                }
                $EmployerMaster->update([
                    'image' => null
                ]);
            }
            return response()->json([
                'data' => asset('images/uploader.png'),
                'message' => 'Country Image Removed '
            ]);
        } catch (\Exception $ex) {

            Log::error($ex->getMessage());

            return response()->json([
                'message' => 'Problem occured'
            ]);
        }
    }

    
}
