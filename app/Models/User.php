<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'telepon',
        'kota_tempat_lahir_id',
        'tanggal_lahir',
        'foto',
        'provinsi_id',
        'kota_id',
        'kecamatan_id',
        'kelurahan_id',
        'kode_pos',
        'detail_alamat',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'email_verified_at' => 'datetime',
            'tanggal_lahir' => 'date',
        ];
    }

    public function kotaTempatLahir()
    {
        return $this->belongsTo(Regency::class, 'kota_tempat_lahir_id');
    }

    public function provinsi()
    {
        return $this->belongsTo(Province::class, 'provinsi_id');
    }

    public function kota()
    {
        return $this->belongsTo(Regency::class, 'kota_id');
    }

    public function kecamatan()
    {
        return $this->belongsTo(District::class, 'kecamatan_id');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Village::class, 'kelurahan_id');
    }

    protected static function boot()
    {
        parent::boot();

        // Saat membuat pengguna baru, generate ID kustom
        static::creating(function ($user) {
            $user->id = $user->generateCustomId();
        });

        // Saat memperbarui pengguna, cek apakah salah satu field yang mempengaruhi ID telah berubah
        static::updating(function ($user) {
            if (
                $user->isDirty('tanggal_lahir') ||
                $user->isDirty('province_id') ||
                $user->isDirty('regency_id') ||
                $user->isDirty('district_id') ||
                $user->isDirty('village_id')
            ) {
                $oldId = $user->getOriginal('id'); // Ambil ID lama sebelum perubahan
                $newId = $user->generateCustomId(); // Generate ID baru berdasarkan field yang berubah
                $user->id = $newId;

                // Perbarui ID di tabel-tabel relasi
                $user->updateRelatedIds($oldId, $newId);
            }
        });
    }

    /**
     * Generate a custom ID based on village ID and birth date.
     *
     * @return string
     */
    public function generateCustomId()
    {
        $villageId = $this->kelurahan_id;
        $birthDate = date('dmy', strtotime($this->tanggal_lahir));

        $userCount = self::where('kelurahan_id', $villageId)->count();
        $uniqueCode = str_pad($userCount + 1, 3, '0', STR_PAD_LEFT);

        return "{$villageId}{$birthDate}{$uniqueCode}";
    }

    /**
     * Update related IDs in other tables.
     *
     * @param string $oldId
     * @param string $newId
     * @return void
     */
    public function updateRelatedIds($oldId, $newId)
    {
        DB::table('user_relationships')->where('user_a', $oldId)->update(['user_id' => $newId]);
        DB::table('user_relationships')->where('user_b', $oldId)->update(['user_id' => $newId]);
    }

    public function isAdmin()
    {
        return $this->is_admin;
    }
}
