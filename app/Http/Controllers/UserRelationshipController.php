<?php

namespace App\Http\Controllers;

use App\Models\UserRelationship;
use App\Models\RelationshipType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRelationshipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Eager load the user_a and user_b relationships for sent relations
        $sentRelations = UserRelationship::where('user_a', $user->id)
            ->whereIn('status', ['pending', 'accepted'])
            ->with(['userA', 'userB'])
            ->get();

        // Eager load the user_a and user_b relationships for received relations
        $receivedRelations = UserRelationship::where('user_b', $user->id)
            ->whereIn('status', ['pending', 'accepted'])
            ->with(['userA', 'userB'])
            ->get();

        // Filter relations by status
        $sentRelationsPending = $sentRelations->where('status', 'pending');
        $receivedRelationsPending = $receivedRelations->where('status', 'pending');

        // Merge sent and received accepted relations
        $relationsAccepted = $sentRelations->where('status', 'accepted')->merge(
            $receivedRelations->where('status', 'accepted')
        );

        // Return view with all relations
        return view('relations', compact(
            'sentRelationsPending',
            'receivedRelationsPending',
            'relationsAccepted'
        ));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userA = Auth::user();
        $userB = User::find($request->related_user_id);

        if ($userA->id == $userB->id) {
            return redirect()->route('relations.index')->with('error', 'You cannot create a relationship with yourself');
        }

        if (!$userB) {
            return redirect()->route('relations.index')->with('error', 'User not found');
        }

        $relationshipTypeId = $request->relationship_type_id;
        if ($request->filled('new_type')) {
            $newType = RelationshipType::create(['name' => $request->new_type]);
            $relationshipTypeId = $newType->id;
        }

        $existingRelationship = UserRelationship::where(function ($query) use ($userA, $userB) {
            $query->where('user_a', $userA->id)
                ->where('user_b', $userB->id);
        })->orWhere(function ($query) use ($userA, $userB) {
            $query->where('user_a', $userB->id)
                ->where('user_b', $userA->id);
        })->first();

        // Buat relasi baru jika belum ada
        if (!$existingRelationship) {
            UserRelationship::create([
                'user_a' => $userA->id,
                'user_b' => $userB->id,
                'relationship_type_id' => $relationshipTypeId,
            ]);
        }

        return redirect()->route('relations.index')->with('success', 'Relation successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $relationshipTypes = RelationshipType::all();
        $user = User::select('id', 'name', 'foto', 'kota_id')
            ->with(['kota:id,name'])
            ->findOrFail($id);
        return view('user', compact('relationshipTypes', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserRelationship $userRelationship)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id)
    {
        $userRelationship = UserRelationship::findOrFail($id);
        if ($userRelationship->status === 'accepted') {
            return back()->with('error', 'This relationship is already accepted.');
        }

        $userRelationship->update(['status' => 'accepted']);

        return redirect(route('relations.index'))->with('success', 'Relationship accepted successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $userRelationship = UserRelationship::findOrFail($id);

        $userRelationship->delete();

        return redirect(route('relations.index'))->with('success', 'Relationship deleted successfully.');
    }
}
