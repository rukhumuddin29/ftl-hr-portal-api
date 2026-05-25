<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\WhatsappTemplate;
use Illuminate\Http\Request;

class WhatsappTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = WhatsappTemplate::with('leadType')->orderBy('id');
        
        if ($request->has('lead_type_id')) {
            $query->where(function($q) use ($request) {
                $q->whereNull('lead_type_id')
                  ->orWhere('lead_type_id', $request->lead_type_id);
            });
        }

        $templates = $query->get();
        return response()->json($templates);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'lead_type_id' => 'nullable|exists:lead_types,id',
            'name' => 'required|string|max:255',
            'body' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $template = WhatsappTemplate::create($validated);
        return response()->json($template, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(WhatsappTemplate $whatsappTemplate)
    {
        return response()->json($whatsappTemplate);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WhatsappTemplate $whatsappTemplate)
    {
        $validated = $request->validate([
            'lead_type_id' => 'nullable|exists:lead_types,id',
            'name' => 'sometimes|required|string|max:255',
            'body' => 'sometimes|required|string',
            'is_active' => 'boolean',
        ]);

        $whatsappTemplate->update($validated);
        return response()->json($whatsappTemplate);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WhatsappTemplate $whatsappTemplate)
    {
        $whatsappTemplate->delete();
        return response()->json(['message' => 'Template deleted']);
    }
}
