<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isNull;

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
        $selectedClass = $request->input('selectedClass');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $page = $request->input('page', 1); // Default to page 1
        $limit = ($request->page == 'all') ? null : $request->input('limit', 10); // If 'all', set limit to null (no pagination)
        $search = $request->input('search'); // Get the search query if provided
    
        // Start the query with sorting
        $query = SchoolClass::query()->orderBy('created_at', 'desc');
        if ($selectedClass) {
            $query->where('name', $selectedClass);
        }
        if ($startDate && $endDate) {
            // Ensure the dates are correctly formatted in 'YYYY-MM-DD' format
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('teacher_in_charge_name', 'LIKE', '%' . $search . '%'); // Example: Searching by teacher's name
            });
        
        }    
        if (is_null($limit)) {
            $filteredClasses = $query->get();
            $response = [
                'class' => $filteredClasses, // Paginated items
                'total' => $filteredClasses->count(), // Total number of items
                'current_page' => 1, // Current page number
                'last_page' => 1 // Total number of pages
            ];

        }else{
            $filteredClasses = $query->paginate($limit, ['*'], 'page', $page);
            $response = [
                'class' => $filteredClasses->items(), // Paginated items
                'total' => $filteredClasses->total(), // Total number of items
                'current_page' => $filteredClasses->currentPage(), // Current page number
                'last_page' => $filteredClasses->lastPage() // Total number of pages
            ];
        }
        // Paginate the filtered results

        return response()->json($response);
    }
    
    
    
    public function view_classes(Request $request)
    {

          // Set default pagination limit and page
    $page = $request->input('page', 1); // Default to page 1
    $limit = ($request->page == 'all') ? null : $request->input('limit', 10); // If 'all', set limit to null (no pagination)
    $search = $request->input('search'); // Search query if provided

    // Build the query with ordering
    $query = SchoolClass::query()->orderBy('created_at', 'desc');

    // Apply search filter if search query is provided
    if (!empty($search)) {
        $query->where(function($q) use ($search) {
            $q->where('name', 'LIKE', '%' . $search . '%')
              ->orWhere('teacher_in_charge_name', 'LIKE', '%' . $search . '%');
        });
    }

    // Fetch records based on pagination or fetch all if limit is null
    if (is_null($limit)) {
        $classes = $query->get(); // Get all records when no pagination
        $response = [
            'class' => $classes, // Return all items directly
            'total' => $classes->count(),
            'current_page' => 1, // Default to page 1 for "all" case
            'last_page' => 1 // Single page when all records are returned
        ];
    } else {
        // Paginate the results if a limit is set
        $classes = $query->paginate($limit, ['*'], 'page', $page);
        $response = [
            'class' => $classes->items(), // Paginated items
            'total' => $classes->total(), // Total number of items
            'current_page' => $classes->currentPage(), // Current page number
            'last_page' => $classes->lastPage() // Total number of pages
        ];
    }
    
    return response()->json($response);

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
        $class->update(["status"=> 2]);
        // $class->delete();
        return response()->json(null, 204);
    }
}
