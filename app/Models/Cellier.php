<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Cellier extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'celliers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom_cellier',
        'user_id',
    ];

    /**
     * Get the user that owns the cellier.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
