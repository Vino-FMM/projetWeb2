<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Bouteille;

class BouteilleCellier extends Model
{
    use HasFactory;

    protected $table = 'bouteilles_celliers';

    protected $fillable = [
        'user_id',
        'bouteille_id',
        'quantite',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bouteille()
    {
        return $this->belongsTo(Bouteille::class);
    }
}
?>