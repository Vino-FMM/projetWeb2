<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cellier extends Model
{
    protected $fillable = ['nom_cellier', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
