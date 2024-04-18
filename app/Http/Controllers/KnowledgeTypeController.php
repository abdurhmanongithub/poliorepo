<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KnowledgeType;

class KnowledgeTypeController extends Controller
{
    public function index()
    {
        $items = KnowledgeType::paginate(10);
        return view('knowledge_types.index', compact('items'));
    }

    public function create()
    {
        return view('knowledge_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:knowledge_types|max:255',
        ]);

        KnowledgeType::create($request->except('_token'));

        return redirect()->route('knowledge-types.index')
            ->with('success', 'Knowledge type created successfully.');
    }

    public function show(KnowledgeType $knowledgeType)
    {
        return view('knowledge_types.show', compact('knowledgeType'));
    }

    public function edit(KnowledgeType $knowledgeType)
    {
        return view('knowledge_types.edit', compact('knowledgeType'));
    }

    public function update(Request $request, KnowledgeType $knowledgeType)
    {
        $request->validate([
            'name' => 'required|unique:knowledge_types|max:255',
        ]);
        $knowledgeType->update(['name' => $request->get('name'), 'description' => $request->get('description')]);

        return redirect()->route('knowledge-types.index')
            ->with('success', 'Knowledge type updated successfully');
    }

    public function destroy(KnowledgeType $knowledgeType)
    {
        $knowledgeType->delete();

        return redirect()->route('knowledge-types.index')
            ->with('success', 'Knowledge type deleted successfully');
    }
}
