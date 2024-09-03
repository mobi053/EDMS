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

    public function is_valid(Request $request) {
        $is_valid = Dir::find($request->id);
    
        if ($is_valid) {
            $is_valid->update(['dir_status' => $request->dir_status]);
            return response()->json(['message' => 'Status updated successfully'], 200);
        } else {
            return response()->json(['error' => 'Record not found'], 404);
        }
    }
    


    /**
     * Display the specified resource.
     */
    public function view_dirs(Request $request){

        $page = $request->input('page', 1); // Default to page 1 if not provided
        $limit = $request->input('limit', 10); // Default to 10 items per page if not provided

        $dir=Dir::paginate($limit, ['*'], 'page', $page);
    
        return response()->json([
            'dir'=>$dir->items(),
            'total'=> $dir->total(),
            'current_page'=> $dir->currentPage(),
            'last_page'=> $dir->lastPage(),
        ]);
    }
    public function show()
    {
        $dirs = Dir::all();
        return response()->json(['dirs' => $dirs]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $del=Dir::where('id', $id)->delete();
        return response()->json(['success' => 'Dir deleted successfully'], 200);
    }
}
