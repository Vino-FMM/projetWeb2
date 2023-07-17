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
        'cellier_id',
        'quantite',
        'nom_bouteille',
        'format_bouteille',
        'prix_bouteille',
        'pays_bouteille',
        'code_saq_bouteille',
        'url_saq_bouteille',
        'url_img_bouteille',
        'millesime_bouteille',
        'type_bouteille',
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