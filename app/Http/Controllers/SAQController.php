<?php

namespace App\Http\Controllers;

use App\Models\Bouteille;
use Illuminate\Http\Request;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class SAQController extends Controller
{
    public function import($nombre = 96)
    {
    //     $importEnabled = false;  // Modifier cette valeur pour activer / désactiver l'importation

    // if (!$importEnabled) {
    //     return response()->json(['message' => 'L\'importation est désactivée']);
    // }
        
        set_time_limit(0);
        
        $client = new Client();
        // Bottle::truncate();
        // Bouteille::truncate();
        
        for($page = 1; $page <= 86; $page++) {
        

            $crawler = $client->request('GET', "https://www.saq.com/fr/produits/vin/vin-rouge?p=".$page."&product_list_limit=".$nombre."&product_list_order=name_asc");

            $crawler->filter('li.product-item')->each(function (Crawler $node) {
                $info = new \stdClass();
                // $info->img = $node->filter('img.product-image-photo')->attr('src');
                $imgSrcset = $node->filter('img.product-image-photo')->attr('srcset');
                $imgUrls = explode(',', $imgSrcset);
                $largestImgUrl = trim(end($imgUrls));
                $info->img = substr($largestImgUrl, 0, strpos($largestImgUrl, ' '));
                $info->url = $node->filter('a')->first()->attr('href');
                $info->titre = $node->filter('span.show-for-sr')->text();
                // $info->price = $node->filter('.price')->text();
                // $info->price = (float) str_replace(['$', ' ', ','], '', $node->filter('.price')->text());

                //le format du prix 
                
                $price = (float) str_replace(['$', ' ', ','], '', $node->filter('.price')->text());
                $formattedPrice = number_format($price / 100, 2);
                $info->price = $formattedPrice;

                $identity = $node->filter('strong.product.product-item-identity-format span')->text();
                $parts = explode(' | ', $identity);
                $info->type = $parts[0];
                $info->bottleSize = $parts[1];
                $info->country = $parts[2];
                // Extract the SAQ code
                $info->saqCode = $node->filter('div.saq-code span')->last()->text();

                //ce bloc la va traiter les millesimes apartir des titres
                $matches = [];
                preg_match('/\b\d{4}\b/', $info->titre, $matches);
                $millesime = isset($matches[0]) ? (int) $matches[0] : null;
                // Create a new Bouteille model and save it to the database
                $bouteille = new Bouteille();
                $bouteille->nom = $info->titre;
                $bouteille->format = $info->bottleSize;
                $bouteille->prix = $info->price;
                $bouteille->pays = $info->country;
                $bouteille->code_saq = $info->saqCode;
                $bouteille->url_saq = $info->url;
                $bouteille->url_img = $info->img;
                $bouteille->millesime = $millesime; // Set the initial millesime to null
                $bouteille->type = $info->type;
                

                $bouteille->save();
            });
        }

        return response()->json(['message' => 'Toutes les bouteilles ont été importé']);
    }

    public function index()
    {
        $bottles = Bouteille::all();
        //on va faire la pagination
        $bottles = Bouteille::paginate(10);
        return view('bouteilles.AjouterBouteilles', ['bottles' => $bottles]);
    }
}
