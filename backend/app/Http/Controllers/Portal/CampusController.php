<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use Illuminate\Http\Request;

class CampusController extends Controller
{
    public function view_campuses(Request $request){  

            // Set default pagination limit and page
      $page = $request->input('page', 1); // Default to page 1
      $limit = ($request->page == 'all') ? null : $request->input('limit', 10); // If 'all', set limit to null (no pagination)
      $search = $request->input('search'); // Search query if provided
  
      // Build the query with ordering
      $query = Campus::query()->orderBy('created_at', 'desc');
  
      // Apply search filter if search query is provided
      if (!empty($search)) {
          $query->where(function($q) use ($search) {
              $q->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('principal', 'LIKE', '%' . $search . '%')
                ->orWhere('location', 'LIKE', '%' . $search . '%');
          });
      }
  
      // Fetch records based on pagination or fetch all if limit is null
      if (is_null($limit)) {
          $campuses = $query->get(); // Get all records when no pagination
          $response = [
              'campuses' => $campuses, // Return all items directly
              'total' => $campuses->count(),
              'current_page' => 1, // Default to page 1 for "all" case
              'last_page' => 1 // Single page when all records are returned
          ];
      } else {
          // Paginate the results if a limit is set
          $campuses = $query->paginate($limit, ['*'], 'page', $page);
          $response = [
              'campuses' => $campuses->items(), // Paginated items
              'total' => $campuses->total(), // Total number of items
              'current_page' => $campuses->currentPage(), // Current page number
              'last_page' => $campuses->lastPage() // Total number of pages
          ];
      }
      
      return response()->json($response);
  

    }
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

    public function store(Request $request)
    {
        // dd($request->all());
        $validateData = $request->validate([
            'name' => 'required|string|max:255',
            'campus_code' => 'required|string|unique:campuses,campus_code|max:50',  // Ensure unique campus codes
            'location' => 'nullable|string',
            'district' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'phone_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'principal' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'parent_school_id' => 'nullable', 
            'campus_type' => 'nullable|string|max:100',
        ]);    
        $campus = Campus::create($validateData);
        return response()->json(['data' => $campus], 201);
    }

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
