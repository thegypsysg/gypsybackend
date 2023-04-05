<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppGroup;
use App\Http\Requests\StoreAppGroupRequest;
use App\Http\Requests\UpdateAppGroupRequest;
use Log;

class AppGroupController extends Controller
{
    public function index(){

        $groups = AppGroup::get();

        return view('pages.app_groups.manage_groups', compact('groups'));
    }

    public function store(StoreAppGroupRequest $request){
        try{
            
            $attributes = $request->validated();

            AppGroup::create($attributes);

            // toastr()->success('Group Added!');

            return redirect()->back();

        } catch(\Exception $ex){
            
            Log::error($ex->getMessage());

            toastr()->error('Problem occured!');

            return redirect()->route('app-groups.index');

        }
    }

    public function edit(AppGroup $app_group) {

        $groups = AppGroup::get();

        return view('pages.app_groups.manage_groups', compact('groups','app_group'));
    }

    public function update(UpdateAppGroupRequest $request, AppGroup $app_group){
       
        try{
            
            $attributes = $request->validated();
            
            AppGroup::find($app_group->app_group_id)->update($attributes);

            // toastr()->success('Group Updated!');

            return redirect()->route('app-groups.index');

        } catch(\Exception $ex){

            Log::error($ex->getMessage());

            toastr()->success('Problem occured!');

            return redirect()->route('app-groups.index');

        }
    }

    public function destroy(AppGroup $app_group){

        try{

            $app_group->delete();

            // toastr()->success('User Deleted!');

        } catch (\Exception $ex) {

            Log::error($ex->getMessage());

        }
        
        return redirect()->route('app-groups.index');
    }
}
