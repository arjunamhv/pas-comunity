<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'kota_tempat_lahir_id' => ['required', 'exists:regencies,id'],
            'tanggal_lahir' => ['required', 'date'],
            'province_id' => ['required', 'exists:provinces,id'],
            'regency_id' => ['required', 'exists:regencies,id'],
            'district_id' => ['required', 'exists:districts,id'],
            'village_id' => ['required', 'exists:villages,id'],
        ]);
        $village = urlencode(Village::find($request->village_id)?->name);
        $response = Http::get("https://kodepos.vercel.app/search/?q=" . $village);
        if ($response->successful()) {
            $villageName = Village::find($request->village_id)?->name;
            $districtName = District::find($request->district_id)?->name;
            $data = $response->json()['data'] ?? [];
            $filteredData = array_filter($data, function ($item) use ($villageName, $districtName) {
                return strtoupper($item['village']) === $villageName &&
                    strtoupper($item['district']) === $districtName;
            });
            $kodePos = $filteredData ? array_values($filteredData)[0]['code'] : null;

            $user = User::create([
                'name' => $request->name,
                'kota_tempat_lahir_id' => $request->kota_tempat_lahir_id,
                'tanggal_lahir' => $request->tanggal_lahir,
                'provinsi_id' => $request->province_id,
                'kota_id' => $request->regency_id,
                'kecamatan_id' => $request->district_id,
                'kelurahan_id' => $request->village_id,
                'kode_pos' => $kodePos,
            ]);

            event(new Registered($user));
            $user = User::where('name', $user->name)
            ->where('tanggal_lahir', $user->tanggal_lahir)
            ->first();

            Auth::login($user);
            $request->session()->regenerate();

            return redirect(route('home'));
        } else {
            return back()->with('error', 'Gagal mendapatkan kode pos');
        }
    }
}
