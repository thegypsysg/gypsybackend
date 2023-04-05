<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\CountryMaster;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(){

        $countries = CountryMaster::get();

        $users = User::get();

        $hasSuperAdmin = $users->contains('type', 'S');

        return view('pages.users.manage_users', compact('countries','users', 'hasSuperAdmin'));
    }

    public function store(StoreUserRequest $request){
        try{
            
            $attributes = $request->validated();
            
            User::create($attributes);

            toastr()->success('User Added!');

            return redirect()->route('users.index');

        } catch(\Exception $ex){
            
            Log::error($ex->getMessage());

            toastr()->error('Problem occured!');

            return redirect()->route('users.index');

        }
    }

    public function edit(User $user){

        $countries = CountryMaster::get();

        $users = User::get();

        $hasSuperAdmin = $users->contains('type', 'S');

        return view('pages.users.manage_users', compact('users', 'countries', 'user', 'hasSuperAdmin'));
    }

    public function update(UpdateUserRequest $request, User $user){
       
        try{
            
            $attributes = $request->validated();
            
            User::find($user->id)->update($attributes);

            toastr()->success('User Updated!');

            return redirect()->route('users.index');

        } catch(\Exception $ex){

            Log::error($ex->getMessage());

            toastr()->success('Problem occured!');

            return redirect()->route('users.index');

        }
    }

    public function destroy(User $user){

        try{

            $user->delete();

            toastr()->success('User Deleted!');

        } catch (\Exception $ex) {

            Log::error($ex->getMessage());

        }
        
        return redirect()->route('users.index');
    }
}
