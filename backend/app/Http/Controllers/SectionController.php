<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    // Get all sections
    public function index()
    {
        $sections = Section::with('class')->get(); // Eager load the class it belongs to
        return response()->json($sections);
    }

    public function view_sections(Request $request)
    {

        // Set default pagination limit and page
        $page = $request->input('page', 1); // Default to page 1
        $limit = ($request->page == 'all') ? null : $request->input('limit', 10); // If 'all', set limit to null (no pagination)
        $search = $request->input('search'); // Search query if provided
        $selectedSection = $request->input('selectedSection');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        // Build the query with ordering
        $query = Section::query()->whereNot('is_deleted', 1)->orderBy('created_at', 'desc');

        if (!empty($selectedSection)) {
            $query->where('name', $selectedSection);
        }
        if (!empty($startDate && $endDate)) {
            // Ensure the dates are correctly formatted in 'YYYY-MM-DD' format
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
        // Apply search filter if search query is provided
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('class_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('campus_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('teacher_in_charge_name', 'LIKE', '%' . $search . '%');
            });
        }

        // Fetch records based on pagination or fetch all if limit is null
        if (is_null($limit)) {
            $sections = $query->get(); // Get all records when no pagination
            $response = [
                'sections' => $sections, // Return all items directly
                'total' => $sections->count(),
                'current_page' => 1, // Default to page 1 for "all" case
                'last_page' => 1 // Single page when all records are returned
            ];
        } else {
            // Paginate the results if a limit is set
            $sections = $query->paginate($limit, ['*'], 'page', $page);
            $response = [
                'sections' => $sections->items(), // Paginated items
                'total' => $sections->total(), // Total number of items
                'current_page' => $sections->currentPage(), // Current page number
                'last_page' => $sections->lastPage() // Total number of pages
            ];
        }

        return response()->json($response);
    }    public function store(Request $request)
    {
        // Validate the incoming request data
        $validateData = $request->validate([
            'name' => 'required|string|max:255',
            'class_name' => 'required|string|max:255',
            'class_id' => 'nullable', // Assuming you have a classes table
            'capacity' => 'nullable',
            'campus_name' => 'nullable',
            'campus_id' => 'nullable', // Assuming you have a campuses table
            'teacher_in_charge_name' => 'nullable',
            'teacher_in_charge_id' => 'nullable', // Assuming you have a teachers table
        ]);

        // Create a new section using mass assignment
        $section = Section::create($validateData);
        // Return a success response with the created section data
        return response()->json([
            'message' => 'Section created successfully',
            'data' => $section,
        ], 201);
    }

    // Get a specific section by ID
    public function show($id)
    {
        $section = Section::with('class')->findOrFail($id);
        return response()->json($section);
    }

    // Update a specific section
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'class_id' => 'required|integer',
            'capacity' => 'required|integer',
        ]);

        $section = Section::findOrFail($id);
        $section->update($validatedData);

        return response()->json($section);
    }

    // Delete a specific section
    public function destroy($id)
    {
        $section = Section::findOrFail($id);
        $section->delete();
        return response()->json(null, 204);
    }
}
