<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHealthCareSetting;
use App\Http\Requests\UpdateHealthCareSetting;
use App\Models\HealthCareSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class HealthCareSettingController extends Controller
{
    public function index(){

        $healthCareSettings = HealthCareSetting::get();

        return view('pages.healthcaresettings.manage_healthcare_settings', compact('healthCareSettings'));
    }

    public function store(StoreHealthCareSetting $request){
        try{
            
            $attributes = $request->validated();
            
            HealthCareSetting::create($attributes);

            toastr()->success('Health care Added!');

            return back();

        } catch(\Exception $ex){
            
            Log::error($ex->getMessage());

            toastr()->error('Problem occured!');

            return back();

        }
    }

    public function edit(HealthCareSetting $healthcaresetting){

        $healthCareSettings = HealthCareSetting::get();

        return view('pages.healthcaresettings.manage_healthcare_settings', compact('healthCareSettings', 'healthcaresetting'));
    }

    public function update(UpdateHealthCareSetting $request, HealthCareSetting $healthcaresetting){
       
        try{
            
            $attributes = $request->validated();
            
            HealthCareSetting::find($healthcaresetting->hs_id)->update($attributes);

            toastr()->success('Health care Updated!');

            return redirect()->route('healthcaresettings.index');

        } catch(\Exception $ex){

            Log::error($ex->getMessage());

            toastr()->success('Problem occured!');

            return back();

        }
    }

    public function destroy(HealthCareSetting $healthcaresetting){

        try{

            $healthcaresetting->delete();

            toastr()->success('Health care Deleted!');

        } catch (\Exception $ex) {

            Log::error($ex->getMessage());

        }
        
        return back();
    }

    public function uploadImage(Request $request)
    {

         try {
            if ($request->hasFile('image')) {

                $image_name = uploadImage($request->image, 'public/HealthCares');
                $fileName = $image_name;

                // Move the file to the public directory
                $request->image->move(public_path('storage/HealthCares'), $fileName);

                // Get the URL for the public file
                $publicUrl = asset('images/' . $fileName);
               
                $filename = str_replace('public/', '', $image_name);
                $HealthCareSetting = HealthCareSetting::find($request->hcs_id);

                if ($HealthCareSetting->image != null && file_exists(Storage::path('public/HealthCares/' . $HealthCareSetting->image))) {
                    Storage::delete('public/HealthCares/' . $HealthCareSetting->image);
                }

                $HealthCareSetting->update([
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
            $HealthCareSetting = HealthCareSetting::find($id);
            if($HealthCareSetting){
                if ($HealthCareSetting->image != null && file_exists(Storage::path('public/HealthCares/' . $HealthCareSetting->image))) {
                    Storage::delete('public/HealthCares/' . $HealthCareSetting->image);
                }
                $HealthCareSetting->update([
                    'image' => null
                ]);
            }
            return response()->json([
                'data' => asset('images/uploader.png'),
                'message' => 'HealthCare Image Removed '
            ]);
        } catch (\Exception $ex) {

            Log::error($ex->getMessage());

            return response()->json([
                'message' => 'Problem occured'
            ]);
        }
    }
}
