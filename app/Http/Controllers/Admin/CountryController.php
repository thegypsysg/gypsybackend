<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCountryRequest;
use App\Http\Requests\UpdateCountryRequest;
use App\Models\CountryMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CountryController extends Controller
{
    public function index()
    {

        $countries = CountryMaster::get();

        return view('pages.countries.manage_countries', compact('countries'));
    }

    public function store(StoreCountryRequest $request)
    {

        try {

            $attributes = $request->validated();

            CountryMaster::create($attributes);

            toastr()->success('Country Added!');

            return redirect()->route('countries.index');
        } catch (\Exception $ex) {

            Log::error($ex->getMessage());

            toastr()->success('Problem occured!');

            return redirect()->route('countries.index');
        }
    }

    public function edit(CountryMaster $country)
    {

        $countries = CountryMaster::get();

        return view('pages.countries.manage_countries', compact('countries', 'country'));
    }

    public function update(UpdateCountryRequest $request, CountryMaster $country)
    {

        try {

            $attributes = $request->validated();

            CountryMaster::find($country->country_id)->update($attributes);

            toastr()->success('Country Updated!');

            return redirect()->route('countries.index');
        } catch (\Exception $ex) {

            Log::error($ex->getMessage());

            toastr()->error('Problem occured!');

            return redirect()->route('countries.index');
        }
    }

    public function destroy(CountryMaster $country)
    {

        try {

            $country->delete();

            toastr()->success('Country Deleted!');
        } catch (\Exception $ex) {

            Log::error($ex->getMessage());

            toastr()->error('Problem occured!');
        }

        return redirect()->route('countries.index');
    }

    public function updateActive(Request $request, CountryMaster $country)
    {
        try {

            CountryMaster::find($country->country_id)->update(['active' => $request->active]);

            $message = "Country activated!";

            if ($request->active == 'N') :
                $message = "Country deactivated!";
            endif;

            return response()->json([
                'message' => $message
            ]);
        } catch (\Exception $ex) {

            Log::error($ex->getMessage());

            return response()->json([
                'message' => 'Problem occured'
            ]);
        }
    }

    public function updateFavorite(Request $request, CountryMaster $country)
    {
        try {

            CountryMaster::find($country->country_id)->update(['favorite' => $request->favorite]);

            $message = 'Country added to favorite';

            if ($request->favorite == 'N') :
                $message = "Country removed from featured!";
            endif;

            return response()->json([
                'message' => $message
            ]);
        } catch (\Exception $ex) {

            Log::error($ex->getMessage());

            return response()->json([
                'message' => 'Problem occured'
            ]);
        }
    }

    public function uploadImage(Request $request)
    {

        try {
            if ($request->hasFile('image')) {

                $image_name = uploadImage($request->image, 'public/Countries');
                $fileName = $image_name;

                // Move the file to the public directory
                $request->image->move(public_path('storage/Countries'), $fileName);

                // Get the URL for the public file
                $publicUrl = asset('images/' . $fileName);
               
                $filename = str_replace('public/', '', $image_name);
                $countryMaster = CountryMaster::find($request->country_id);

                if ($countryMaster->image != null && file_exists(Storage::path('public/Countries/' . $countryMaster->image))) {
                    Storage::delete('public/Countries/' . $countryMaster->image);
                }

                $countryMaster->update([
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
            $countryMaster = CountryMaster::find($id);
            if($countryMaster){
                if ($countryMaster->image != null && file_exists(Storage::path('public/Countries/' . $countryMaster->image))) {
                    Storage::delete('public/Countries/' . $countryMaster->image);
                }
                $countryMaster->update([
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
