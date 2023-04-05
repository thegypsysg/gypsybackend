<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSkillRequest;
use App\Http\Requests\UpdateSkillRequest;
use App\Models\SkillGroupMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SkillController extends Controller
{
    public function index(){

        $skills = SkillGroupMaster::get();

        return view('pages.skills.manage_skills', compact('skills'));
    }

    public function store(StoreSkillRequest $request){
        
        try{
            
            $attributes = $request->validated();

            SkillGroupMaster::create($attributes);

            toastr()->success('Skill Added!');

            return redirect()->route('skills.index');

        } catch(\Exception $ex){
            
            Log::error($ex->getMessage());

            toastr()->error('Problem occured!');

            return redirect()->route('skills.index');

        }
    }

    public function edit(SkillGroupMaster $skill){

        $skills = SkillGroupMaster::get();

        return view('pages.skills.manage_skills', compact('skills', 'skill'));
    }

    public function update(UpdateSkillRequest $request, SkillGroupMaster $skill){
       
        try{
            
            $attributes = $request->validated();
            
            SkillGroupMaster::find($skill->sgm_id)->update($attributes);

            toastr()->success('Skill Updated!');

            return redirect()->route('skills.index');

        } catch(\Exception $ex){

            Log::error($ex->getMessage());

            toastr()->error('Problem occured!');

            return redirect()->route('skills.index');

        }
    }

    public function destroy(SkillGroupMaster $skill){

        try{

            $skill->delete();

            toastr()->success('Skill Deleted!');

        } catch (\Exception $ex) {

            Log::error($ex->getMessage());

            toastr()->error('Problem occured!');

        }
        
        return redirect()->route('skills.index');
    }

    public function uploadImage(Request $request){
       
        try{
            if ($request->hasFile('image')) {
                
                $image_name = uploadImage($request->image, 'Skills');
                $fileName = $image_name;

                // Move the file to the public directory
                $request->image->move(public_path('storage/Skills'), $fileName);

                // Get the URL for the public file
                $publicUrl = asset('images/' . $fileName);

                SkillGroupMaster::find($request->sgm_id)->update([
                    'image'=> basename($image_name)
                ]);
                
                $image = SkillGroupMaster::select('image')->find($request->sgm_id);
                
                return response()->json([
                    'data' => imageUrl('Skills', $image->image),
                    'message' => 'Image uploaded'
                ]);
            }
        } catch(\Exception $ex){

            Log::error($ex->getMessage());

            return response()->json([
                'message' => 'Problem occured'
            ]);
        }
        
    }
    public function imageRemove($id){
        try {
            $SkillGroupMaster = SkillGroupMaster::find($id);
            if($SkillGroupMaster){
                if ($SkillGroupMaster->image != null && file_exists(Storage::path('public/SKills/' . $SkillGroupMaster->image))) {
                    Storage::delete('public/Skills/' . $SkillGroupMaster->image);
                }
                $SkillGroupMaster->update([
                    'image' => null
                ]);
            }
            return response()->json([
                'data' => asset('images/uploader.png'),
                'message' => 'Skill Image Removed '
            ]);
        } catch (\Exception $ex) {

            Log::error($ex->getMessage());

            return response()->json([
                'message' => 'Problem occured'
            ]);
        }
    }
}
