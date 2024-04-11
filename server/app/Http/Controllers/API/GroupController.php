<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::all();
        return response()->json($groups);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'owner_id' => 'required|exists:users,id'
        ]);

        $group = Group::create($request->all());
        return response()->json($group, 201);
    }

    public function show($id)
    {
        $group = Group::findOrFail($id);
        return response()->json($group);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'owner_id' => 'required|exists:users,id'
        ]);

        $group = Group::findOrFail($id);
        $group->update($request->all());
        return response()->json($group, 200);
    }

    public function destroy($id)
    {
        $group = Group::findOrFail($id);
        $group->delete();
        return response()->json(null, 204);
    }
}
