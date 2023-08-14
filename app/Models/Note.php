<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\BouteilleCellier;

class Note extends Model
{
    use HasFactory;

    protected $table='notes';

    protected $fillable = [
        'bouteille_cellier_id',
        'text',
    ];

    public function bouteilleCellier()
    {
        return $this->belongsTo(BouteilleCellier::class);
    }
}
