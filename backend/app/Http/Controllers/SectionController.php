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

    // Store a new section
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'class_id' => 'required|integer',
            'capacity' => 'required|integer',
        ]);

        $section = Section::create($validatedData);
        return response()->json($section, 201);
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
