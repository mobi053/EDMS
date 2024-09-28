<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    // Get all classes
    public function index()
    {
        $classes = SchoolClass::with('sections')->get(); // Eager load sections
        return response()->json($classes);
    }

    public function filter(Request $request)
    {
        // Retrieve filtering parameters from the request
        $selectedClass = $request->input('selectedClass');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $page = $request->input('page', 1); // Default to page 1
        $limit = $request->input('limit', 10); // Default to 10 items per page
        $search = $request->input('search'); // Get the search query if provided

        // Start the query
        $query = SchoolClass::query(); // Make sure SchoolClass is your model
    
        // Apply class name filter if provided
        if ($selectedClass) {
            $query->where('name', $selectedClass);
        }
    
        // Apply date range filter if both startDate and endDate are provided
        if ($startDate && $endDate) {
            // Ensure the dates are correctly formatted in 'YYYY-MM-DD' format
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
        if ($search) {
            $query->whereBetween('created_at', [$startDate, $endDate])
                  ->orwhere('name', 'LIKE', '%' . $search . '%') // Assuming 'name' is the searchable field
                  ->orWhere('teacher_in_charge_name', 'LIKE', '%' . $search . '%'); // Example: Searching by teacher's name
        }
    
        // Paginate the filtered results
        $filteredClasses = $query->paginate($limit, ['*'], 'page', $page);
    
        // Return the filtered results as JSON
        return response()->json($filteredClasses);
    }
    
    public function view_classes(Request $request)
    {
        $page = $request->input('page', 1); // Default to page 1 if not provided
        $limit = $request->input('limit', 10); // Default to 10 items per page if not provided
        $search = $request->input('search'); // Get the search query if provided
    
        // Build the query
        $query = SchoolClass::query()->orderby('created_at', 'desc');
    
        // Apply search filter if search query is provided
        if ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%') // Assuming 'name' is the searchable field
                  ->orWhere('teacher_in_charge_name', 'LIKE', '%' . $search . '%'); // Example: Searching by teacher's name
        }
    
        // Paginate the filtered query
        $class = $query->paginate($limit, ['*'], 'page', $page);
    
        return response()->json([
            'class' => $class->items(),
            'total' => $class->total(),
            'current_page' => $class->currentPage(),
            'last_page' => $class->lastPage(),
        ]);
    }
    

    // Store a new class
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',       // Name is required, must be a string, and can have a max length of 255 characters.
            'school_id' => 'nullable',                 // Optional, can be null.
            'teacher_in_charge_id' => 'nullable',      // Optional, can be null.
            'teacher_in_charge_name' => 'nullable',    // Optional, can be null.
            'status' => 'nullable',                    // Optional, can be null.
        ]);
        
        $class = SchoolClass::create($validatedData);
        return response()->json($class, 201);
    }

    public function edit($id)
    {
        $dir = SchoolClass::find($id);
        return response()->json(['data'=>$dir], 200);
    }

    // Get a specific class by ID
    public function show($id)
    {
        $class = SchoolClass::with('sections')->findOrFail($id);
        return response()->json($class);
    }

    // Update a specific class
    public function update(Request $request, $id)
    {
        // Find the record by ID
        $dir = SchoolClass::find($id);
    
        if (!$dir) {
            return response()->json(['message' => 'Record not found'], 404);
        }
    
        // Update the record with request data
        $dir->update($request->all());
    
        // Return a success response
        return response()->json(['message' => 'Record updated successfully', 'data' => $dir], 200);
    }


    // Delete a specific class
    public function destroy($id)
    {
        $class = SchoolClass::findOrFail($id);
        $class->delete();
        return response()->json(null, 204);
    }
}
