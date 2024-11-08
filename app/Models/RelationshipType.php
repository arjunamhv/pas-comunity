<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\UserRelationship;

class RelationshipType extends Model
{
    protected $table = 'relationship_types';
    protected $fillable = ['name'];

    public function relationships()
    {
        return $this->hasMany(UserRelationship::class, 'relationship_type_id');
    }
}
