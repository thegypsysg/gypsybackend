<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployerContactRequest;
use App\Http\Requests\UpdateEmployerContactRequest;
use App\Models\EmployerContact;
use App\Models\EmployerMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmployerContactController extends Controller
{
    public function show($id){
        
        $employer = EmployerMaster::with('contacts')->find($id);

        return view('pages.employers.contacts', compact('employer'));
    }

    public function store(StoreEmployerContactRequest $request){
        try{
            
            $attributes = $request->validated();
            
            EmployerContact::create($attributes);

            toastr()->success('Contact Added!');

            return back();

        } catch(\Exception $ex){
            
            Log::error($ex->getMessage());

            toastr()->error('Problem occured!');

            return back();

        }
    }

    public function edit(EmployerContact $employerContact){

        $employer = EmployerMaster::with('contacts')->find($employerContact->employer_id);

        return view('pages.employers.contacts', compact('employer', 'employerContact'));
    }

    public function update(UpdateEmployerContactRequest $request, EmployerContact $employerContact){
       
        try{
            
            $attributes = $request->validated();
            
            EmployerContact::find($employerContact->ec_id)->update($attributes);

            toastr()->success('Contact Updated!');

            return redirect()->route('employer-contacts.show', $employerContact->employer_id);

        } catch(\Exception $ex){

            Log::error($ex->getMessage());

            toastr()->error('Problem occured!');

            return back();

        }
    }

    public function destroy(EmployerContact $employerContact){

        try{
           
            $employerContact->delete();

            toastr()->success('Contact Deleted!');

        } catch (\Exception $ex) {

            Log::error($ex->getMessage());

        }
        
        return back();
    }
}
