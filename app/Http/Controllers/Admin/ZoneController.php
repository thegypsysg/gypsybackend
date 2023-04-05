<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreZoneRequest;
use App\Http\Requests\UpdateZoneRequest;
use App\Models\ZoneMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ZoneController extends Controller
{
    public function index(){

        $zones = ZoneMaster::get();

        return view('pages.zones.manage_zones', compact('zones'));
    }

    public function store(StoreZoneRequest $request){
        try{
            
            $attributes = $request->validated();
            
            ZoneMaster::create($attributes);

            toastr()->success('Zone Added!');

            return redirect()->route('zones.index');

        } catch(\Exception $ex){
            
            Log::error($ex->getMessage());

            toastr()->error('Problem occured!');

            return redirect()->route('zones.index');

        }
    }

    public function edit(ZoneMaster $zone){

        $zones = ZoneMaster::get();

        return view('pages.zones.manage_zones', compact('zone', 'zones'));
    }

    public function update(UpdateZoneRequest $request, ZoneMaster $zone){
       
        try{
            
            $attributes = $request->validated();
            
            ZoneMaster::find($zone->zone_id)->update($attributes);

            toastr()->success('Town Updated!');

            return redirect()->route('zones.index');

        } catch(\Exception $ex){

            Log::error($ex->getMessage());

            toastr()->success('Problem occured!');

            return redirect()->route('zones.index');

        }
    }

    public function destroy(ZoneMaster $zone){

        try{

            $zone->delete();

            toastr()->success('Zone Deleted!');

        } catch (\Exception $ex) {

            Log::error($ex->getMessage());

        }
        
        return redirect()->route('zones.index');
    }
}
