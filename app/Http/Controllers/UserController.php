<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Village;
use App\Models\District;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Regency;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::with(['kota', 'provinsi', 'kecamatan', 'kelurahan']);

        if ($request->has('search') && $request->search != '') {
            switch ($request->filter) {
                case 'provinsi':
                    $query->whereHas('provinsi', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
                    break;
                case 'kota':
                    $query->whereHas('kota', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
                    break;
                case 'kecamatan':
                    $query->whereHas('kecamatan', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
                    break;
                case 'kelurahan':
                    $query->whereHas('kelurahan', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
                    break;
                case 'admin':
                    $query->where('is_admin', $request->search === 'admin');
                    break;
                default:
                    $query->where('name', 'like', '%' . $request->search . '%');
                    break;
            }
        }

        $users = $query->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = new User();

        // Handle foto upload and background removal
        if ($request->hasFile('foto')) {
            $filePath = $request->file('foto')->getRealPath();
            $apiKey = 'FXZzcfLdbMjhoLMnCQ7xEHth';

            try {
                $client = new \GuzzleHttp\Client();
                $res = $client->post('https://api.remove.bg/v1.0/removebg', [
                    'multipart' => [
                        [
                            'name' => 'image_file',
                            'contents' => fopen($filePath, 'r')
                        ],
                        [
                            'name' => 'size',
                            'contents' => 'auto'
                        ]
                    ],
                    'headers' => [
                        'X-Api-Key' => $apiKey
                    ]
                ]);

                if ($res->getStatusCode() === 200) {
                    $filename = 'foto-id-card/' . Str::uuid() . '.png';
                    Storage::disk('public')->put($filename, $res->getBody());
                    $user->foto = $filename;
                } else {
                    return Redirect::route('users.create')->withErrors('Failed to remove background from the image.');
                }
            } catch (\Exception $e) {
                return Redirect::route('users.create')->withErrors('Error connecting to Remove.bg API: ' . $e->getMessage());
            }
        }

        // Get village and district names for postal code lookup
        $villageName = Village::find($request->village_id)?->name;
        $districtName = District::find($request->district_id)?->name;

        // Retrieve postal code from API if village name exists
        if ($villageName && $districtName) {
            $response = Http::get("https://kodepos.vercel.app/search/?q=" . $villageName);
            if ($response->successful()) {
                $data = $response->json()['data'] ?? [];
                $filteredData = array_filter($data, function ($item) use ($villageName, $districtName) {
                    return strtoupper($item['village']) === strtoupper($villageName) &&
                        strtoupper($item['district']) === strtoupper($districtName);
                });
                $user->kode_pos = $filteredData ? array_values($filteredData)[0]['code'] : null;
            } else {
                return Redirect::route('users.create')->withErrors('Failed to retrieve postal code.');
            }
        }

        // Assign user data from request
        $user->name = $request->name;
        $user->email = $request->email;
        $user->telepon = $request->telepon;
        $user->kota_tempat_lahir_id = $request->kota_tempat_lahir_id;
        $user->tanggal_lahir = $request->tanggal_lahir;
        $user->provinsi_id = $request->province_id;
        $user->kota_id = $request->regency_id;
        $user->kecamatan_id = $request->district_id;
        $user->kelurahan_id = $request->village_id;
        $user->detail_alamat = $request->detail_alamat;
        $user->is_admin = $request->is_admin;

        // Save user data to the database
        $user->save();

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        User::find($user->id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        // Handle foto upload and background removal
        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $filePath = $request->file('foto')->getRealPath();
            $apiKey = 'FXZzcfLdbMjhoLMnCQ7xEHth';

            try {
                $client = new \GuzzleHttp\Client();
                $res = $client->post('https://api.remove.bg/v1.0/removebg', [
                    'multipart' => [
                        [
                            'name' => 'image_file',
                            'contents' => fopen($filePath, 'r')
                        ],
                        [
                            'name' => 'size',
                            'contents' => 'auto'
                        ]
                    ],
                    'headers' => [
                        'X-Api-Key' => $apiKey
                    ]
                ]);

                if ($res->getStatusCode() === 200) {
                    $filename = 'foto-id-card/' . Str::uuid() . '.png';
                    Storage::disk('public')->put($filename, $res->getBody());
                    $user->foto = $filename;
                } else {
                    return Redirect::route('users.edit')->withErrors('Failed to remove background from the image.');
                }
            } catch (\Exception $e) {
                return Redirect::route('users.edit')->withErrors('Error connecting to Remove.bg API: ' . $e->getMessage());
            }
        }

        // Get village and district names for postal code lookup
        $villageName = Village::find($request->village_id)?->name;
        $districtName = District::find($request->district_id)?->name;

        // Retrieve postal code from API if village name exists
        if ($villageName && $districtName) {
            $response = Http::get("https://kodepos.vercel.app/search/?q=" . $villageName);
            if ($response->successful()) {
                $data = $response->json()['data'] ?? [];
                $filteredData = array_filter($data, function ($item) use ($villageName, $districtName) {
                    return strtoupper($item['village']) === strtoupper($villageName) &&
                        strtoupper($item['district']) === strtoupper($districtName);
                });
                $user->kode_pos = $filteredData ? array_values($filteredData)[0]['code'] : null;
            } else {
                return Redirect::route('users.edit')->withErrors('Failed to retrieve postal code.');
            }
        }

        // Assign user data from request
        $user->name = $request->name;
        $user->email = $request->email;
        $user->telepon = $request->telepon;
        $user->kota_tempat_lahir_id = $request->kota_tempat_lahir_id;
        $user->tanggal_lahir = $request->tanggal_lahir;
        $user->provinsi_id = $request->province_id;
        $user->kota_id = $request->regency_id;
        $user->kecamatan_id = $request->district_id;
        $user->kelurahan_id = $request->village_id;
        $user->detail_alamat = $request->detail_alamat;
        $user->is_admin = $request->is_admin;

        // Save user data to the database
        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
