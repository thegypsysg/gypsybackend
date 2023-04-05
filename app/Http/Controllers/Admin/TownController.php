<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTownRequest;
use App\Http\Requests\UpdateTownRequest;
use App\Models\CityMaster;
use App\Models\TownMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TownController extends Controller
{
    public function index(){

        $towns = TownMaster::get();

        $cities = CityMaster::select('city_id', 'city_name')->get();

        return view('pages.towns.manage_towns', compact('cities','towns'));
    }

    public function store(StoreTownRequest $request){
        try{
            
            $attributes = $request->validated();
            
            TownMaster::create($attributes);

            toastr()->success('Town Added!');

            return redirect()->route('towns.index');

        } catch(\Exception $ex){
            
            Log::error($ex->getMessage());

            toastr()->error('Problem occured!');

            return redirect()->route('towns.index');

        }
    }

    public function edit(TownMaster $town){

        $towns = TownMaster::get();

        $cities = CityMaster::select('city_id', 'city_name')->get();

        return view('pages.towns.manage_towns', compact('cities', 'town', 'towns'));
    }

    public function update(UpdateTownRequest $request, TownMaster $town){
       
        try{
            
            $attributes = $request->validated();
            
            TownMaster::find($town->town_id)->update($attributes);

            toastr()->success('Town Updated!');

            return redirect()->route('towns.index');

        } catch(\Exception $ex){

            Log::error($ex->getMessage());

            toastr()->success('Problem occured!');

            return redirect()->route('towns.index');

        }
    }

    public function destroy(TownMaster $town){

        try{

            $town->delete();

            toastr()->success('Town Deleted!');

        } catch (\Exception $ex) {

            Log::error($ex->getMessage());

        }
        
        return redirect()->route('towns.index');
    }
}
