<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CommunityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $me = Auth::user();
        $searchResults = [];

        if ($request->has('filter') && $request->has('search') && $request->search) {
            $filter = $request->filter;
            $searchTerm = $request->search;

            $query = User::query();

            if ($filter === 'name') {
                $query->where('name', 'like', '%' . $searchTerm . '%');
            } elseif ($filter === 'provinsi') {
                $query->whereHas('provinsi', function ($q) use ($searchTerm) {
                    $q->where('name', 'like', '%' . $searchTerm . '%');
                });
            } elseif ($filter === 'kota') {
                $query->whereHas('kota', function ($q) use ($searchTerm) {
                    $q->where('name', 'like', '%' . $searchTerm . '%');
                });
            } elseif ($filter === 'kecamatan') {
                $query->whereHas('kecamatan', function ($q) use ($searchTerm) {
                    $q->where('name', 'like', '%' . $searchTerm . '%');
                });
            } elseif ($filter === 'kelurahan') {
                $query->whereHas('kelurahan', function ($q) use ($searchTerm) {
                    $q->where('name', 'like', '%' . $searchTerm . '%');
                });
            }

            $searchResults = $query->get();
        }

        $newMembers = [];
        $newMembers = User::where('created_at', '>=', Carbon::now()->subWeek())
            ->latest()
            ->take(5)
            ->whereNot('id', $me->id)
            ->get();

        $nearbyMembers = [];

        if ($request->has('kecamatan_id') && $request->kecamatan_id) {
            $nearbyMembers = User::where('kecamatan_id', $request->kecamatan_id)
                ->where('id', '!=', $me->id)
                ->inRandomOrder()
                ->take(5)
                ->get();

            if ($nearbyMembers->isEmpty() && $request->has('kota_id')) {
                $nearbyMembers = User::where('kota_id', $request->kota_id)
                    ->where('id', '!=', $me->id)
                    ->inRandomOrder()
                    ->take(5)
                    ->get();
            }

            if ($nearbyMembers->isEmpty() && $request->has('provinsi_id')) {
                $nearbyMembers = User::where('provinsi_id', $request->provinsi_id)
                    ->where('id', '!=', $me->id)
                    ->inRandomOrder()
                    ->take(5)
                    ->get();
            }
        }

        return view('community', compact('searchResults', 'newMembers', 'nearbyMembers'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
