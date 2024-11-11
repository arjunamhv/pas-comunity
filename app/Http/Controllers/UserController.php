<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Regency;
use App\Models\Village;
use App\Models\District;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\UserRelationship;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function user($id)
    {
        $user = User::select('id', 'name', 'foto', 'kota_id')
            ->with(['kota:id,name'])
            ->findOrFail($id);

        return view('user', compact('user'));
    }


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
        $oldValues = [
            'tanggal_lahir' => $user->tanggal_lahir,
            'provinsi_id' => $user->provinsi_id,
            'kota_id' => $user->kota_id,
            'kecamatan_id' => $user->kecamatan_id,
            'kelurahan_id' => $user->kelurahan_id,
        ];
        $oldId = $user->id;

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

        $changed = false;
        $changedAttributes = [];

        foreach ($oldValues as $key => $oldValue) {
            // Ambil nilai baru dari request
            $newValue = $request->{$key};

            // Jika nilai lama berbeda dengan nilai baru, tandai perubahan
            if ($oldValue !== $newValue) {
                $changed = true;
                $changedAttributes[$key] = ['old' => $oldValue, 'new' => $newValue];
            }
        }

        if ($changed) {
            // Call the function to generate a custom ID
            $user->id = $this->generateCustomId($user);
            $this->updateRelatedIds($oldId, $user->id);
        }

        // Save user data to the database
        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Generate a custom ID for the user.
     * @param $user
     * @return string
     */
    private function generateCustomId($user)
    {
        $villageId = $user->kelurahan_id;
        $birthDate = date('dmy', strtotime($user->tanggal_lahir));

        $userCount = User::where('kelurahan_id', $villageId)->count();
        $uniqueCode = str_pad($userCount + 1, 3, '0', STR_PAD_LEFT);

        return "{$villageId}{$birthDate}{$uniqueCode}";
    }
    /**
     * Update related IDs in other tables.
     * @param $oldId
     * @param $newId
     * @return void
     */
    private function updateRelatedIds($oldId, $newId)
    {
        UserRelationship::where('user_a', $oldId)->update(['user_id' => $newId]);
        UserRelationship::where('user_b', $oldId)->update(['user_id' => $newId]);
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
