<?php

namespace App\Http\Controllers;

use App\Models\Knowledge;
use App\Models\KnowledgeType;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class KnowledgeController extends Controller
{
    public function index()
    {
        $items = Knowledge::paginate(10);
        return view('knowledge.index', compact('items'));
    }

    public function create()
    {
        return view('knowledge.create', ['subcategories' => SubCategory::all(), 'knowledgetypes' => KnowledgeType::all()]);
    }

    public function store(Request $request)
    {
        Knowledge::create($request->except('_token'));
        return redirect()->route('knowledge.index')->with('success', 'Knowledge  created successfully.');

    }

    public function show(Knowledge $knowledge)
    {
        return view('knowledge.show', compact('knowledge'));
    }

    public function edit(Knowledge $knowledge)
    {
        return view('knowledge.edit', ['subcategories' => SubCategory::all(), 'knowledgetypes' => KnowledgeType::all(), 'knowledge' => $knowledge]);
    }

    public function update(Request $request, Knowledge $knowledge)
    {
        $knowledge->update($request->all());
        return redirect()->route('knowledge.index')->with('success', 'Knowledge  updated successfully.');
    }

    public function destroy(Knowledge $knowledge)
    {
        $knowledge->delete();
        return redirect()->route('knowledge.index')->with('success', 'Knowledge  deleted successfully.');
    }
}
