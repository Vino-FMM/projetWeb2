<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use App\Models\Cellier;


class Bouteille extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bouteilles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'format',
        'prix',
        'pays',
        'code_saq',
        'url_saq',
        'url_img',
        'millesime',
        'type',
    ];

    /**
     * Get the cellier that owns the bouteille.
     */
    // public function cellier()
    // {
    //     return $this->belongsTo(Cellier::class);
    // }
}


