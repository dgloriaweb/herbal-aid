<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    
    protected $fillable = ['scientific_name', 'species_id'];

    public function species()
    {
        return $this->belongsTo(Species::class);
    }
}
