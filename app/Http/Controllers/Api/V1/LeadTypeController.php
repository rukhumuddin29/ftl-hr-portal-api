<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\LeadType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LeadTypeController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data' => LeadType::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'form_schema' => 'nullable|array'
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $leadType = LeadType::create($validated);

        return response()->json([
            'status' => 'success',
            'data' => $leadType,
            'message' => 'Lead Type created successfully'
        ], 201);
    }

    public function show(LeadType $leadType)
    {
        return response()->json([
            'status' => 'success',
            'data' => $leadType
        ]);
    }

    public function update(Request $request, LeadType $leadType)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:100',
            'form_schema' => 'nullable|array'
        ]);

        if (isset($validated['name'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $leadType->update($validated);

        return response()->json([
            'status' => 'success',
            'data' => $leadType,
            'message' => 'Lead Type updated successfully'
        ]);
    }

    public function destroy(LeadType $leadType)
    {
        $leadType->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Lead Type deleted successfully'
        ]);
    }
}
