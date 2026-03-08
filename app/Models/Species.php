<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Species extends Model
{
    protected $fillable = ['name', 'parent_id', 'rank'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
