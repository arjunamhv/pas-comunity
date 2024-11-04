<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Village;
use Illuminate\Http\Request;


class AddressController extends Controller
{
    // Mengambil semua provinsi
    public function getProvinsi()
    {
        $provinsi = Province::all(['id', 'name']);
        return response()->json($provinsi);
    }

    // Mengambil kota berdasarkan provinsi
    public function getKota(Request $request)
    {
        $request->validate(['province_id' => 'required|integer']);
        $kota = Regency::where('province_id', $request->province_id)->get(['id', 'name']);
        return response()->json($kota);
    }

    // Mengambil kecamatan berdasarkan kota
    public function getKecamatan(Request $request)
    {
        $request->validate(['regency_id' => 'required|integer']);
        $kecamatan = District::where('regency_id', $request->regency_id)->get(['id', 'name']);
        return response()->json($kecamatan);
    }

    // Mengambil kelurahan berdasarkan kecamatan
    public function getKelurahan(Request $request)
    {
        $request->validate(['district_id' => 'required|integer']);
        $kelurahan = Village::where('district_id', $request->district_id)->get(['id', 'name']);
        return response()->json($kelurahan);
    }
}
