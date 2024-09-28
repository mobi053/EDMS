<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use Illuminate\Http\Request;

class CampusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $campuses=Campus::all();
        return response()->json(['data'=>$campuses, 200]);
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
        // dd($request->all());
        $validateData= $request->validate([
            'name' => 'required|string|max:255',
            'campus_code' => 'required|integer',
            'location' => 'nullable',
            'district' => 'nullable',
        ]);
        $campus=Campus::create($validateData);
        return response()->json(['data'=>$campus, 201]);
        // 'name' => $request->name,
        // 'campus_code' => $request->capmus_code,
        // 'location' => $request->location->nullable(),
        // 'district' => $request->district
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $campus=Campus::findorfail($id);
        return response()->json(['data'=> $campus]);
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
