<?php

namespace App\Http\Controllers;

use App\Models\Dir;
use Illuminate\Http\Request;

class DirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dirs = Dir::all();
        return response()->json(['dirs' => $dirs]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dir= new Dir ([
            'lead_id'=> $request->lead_id,
            'observation_id' => $request->observation_id,
            'title'=> $request->title,
            'dir_number' => $request->dir_number,
            'camera_id' => $request->camera_id,
            'finding_status' => $request->finding_status,
            'finding_remarks' => $request->finding_remarks,
            'created_by' => $request->created_by,
            'department_id'=> $request->department_id,
            'local_cameras_status' => $request->local_cameras_status,
            'total_cameras' => $request->total_cameras,
            'dir_status' => $request->dir_status,
            'dir_date' => $request->dir_date,
            'is_deleted' => $request->is_deleted,
        ]);
        $dir->save();
      
        return response()->json(['message'=>'DIR entered Successfully!!']);
    } 


    /**
     * Display the specified resource.
     */
    public function view_dirs(){
        $dir=Dir::all();
        return response()->json(['dir'=>$dir]);
    }
    public function show()
    {
        $dirs = Dir::all();
        return response()->json(['dirs' => $dirs]);
    }

    public function edit($id)
    {
        $dir = Dir::find($id);
        if ($dir) {
            return response()->json(['dir' => $dir]);
        } else {
            return response()->json(['message' => 'Record not found'], 404);
        }
    }



    public function update(Request $request)
    {
        $dir = Dir::find($request->id);    
        if (!$dir) {
            return response()->json(['message' => 'DIR not found!'], 404);
        }
    
        // Update the fields with new values from the request
        $dir->lead_id = $request->lead_id ?? $dir->lead_id;
        $dir->observation_id = $request->observation_id ?? $dir->observation_id;
        $dir->title = $request->title ?? $dir->title;
        $dir->dir_number = $request->dir_number ?? $dir->dir_number;
        $dir->camera_id = $request->camera_id ?? $dir->camera_id;
        $dir->finding_status = $request->finding_status ?? $dir->finding_status;
        $dir->finding_remarks = $request->finding_remarks ?? $dir->finding_remarks;
        $dir->created_by = $request->created_by ?? $dir->created_by;
        $dir->department_id = $request->department_id ?? $dir->department_id;
        $dir->local_cameras_status = $request->local_cameras_status ?? $dir->local_cameras_status;
        $dir->total_cameras = $request->total_cameras ?? $dir->total_cameras;
        $dir->dir_status = $request->dir_status ?? $dir->dir_status;
        $dir->dir_date = $request->dir_date ?? $dir->dir_date;
        $dir->is_deleted = $request->is_deleted ?? $dir->is_deleted;
    
        // Save the updated model
        $dir->save();
    
        return response()->json(['message' => 'DIR updated successfully!']);
    }
    
    public function destroy($id)
    {
        $del=Dir::where('id', $id)->delete();
        return response()->json(['success' => 'Dir deleted successfully'], 200);
    }
    public function is_valid(Request $request) {
        $is_valid = Dir::find($request->id);
    
        if ($is_valid) {
            $is_valid->update(['dir_status' => $request->dir_status]);
            return response()->json(['message' => 'Status updated successfully'], 200);
        } else {
            return response()->json(['error' => 'Record not found'], 404);
        }
    }
 
   
}
