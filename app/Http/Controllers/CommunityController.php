<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class CommunityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Pencarian berdasarkan nama
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Menampilkan anggota terbaru yang bergabung
        $newMembers = User::latest()->take(5)->get(); // 5 anggota terbaru

        // Mengambil data anggota berdasarkan lokasi jika diperlukan
        // Misalnya, menggunakan lat dan long untuk mencari anggota terdekat
        if ($request->has('nearby') && $request->nearby) {
            // Proses mencari anggota berdasarkan jarak
            // Gunakan package seperti "geotools" atau kalkulasi manual berdasarkan lat long
            $nearbyMembers = User::where('location', 'near', $request->location)->get();
        } else {
            $nearbyMembers = [];
        }

        $members = $query->get();

        return view('community', compact('members', 'newMembers', 'nearbyMembers'));
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
