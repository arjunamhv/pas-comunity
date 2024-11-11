<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserRelationship extends Model
{
    protected $table = 'user_relationships';
    protected $fillable = ['user_a', 'user_b', 'relationship_type_id', 'status'];

    public function type()
    {
        return $this->belongsTo(RelationshipType::class, 'relationship_type_id');
    }

    public function userA()
    {
        return $this->belongsTo(User::class, 'user_a');
    }

    public function userB()
    {
        return $this->belongsTo(User::class, 'user_b');
    }
}
