<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRelationship extends Model
{
    protected $table = 'user_relationships';
    protected $fillable = ['user_a', 'user_b', 'relationship_type_id'];

    public function type()
    {
        return $this->belongsTo(RelationshipType::class, 'relationship_type_id');
    }

    public function user_a()
    {
        return $this->belongsTo(User::class, 'user_a');
    }

    public function user_b()
    {
        return $this->belongsTo(User::class, 'user_b');
    }
}
