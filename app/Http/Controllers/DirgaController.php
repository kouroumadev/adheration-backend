<?php

namespace App\Http\Controllers;

use App\Models\Entreprise;
use Dotenv\Parser\Entry;
use Illuminate\Http\Request;
use DB;

class DirgaController extends Controller
{
    public function getAllAffiliation(){

        $data = DB::table('entreprises as ent')
                    ->join('branche as br','br.code','=','ent.activite_principale')
                    ->join('communes as com','com.id','=','ent.commune_entreprise')
                    ->join('prefecture as preff','preff.code','=','ent.ville_entreprise')
                    ->join('representants as rep','rep.entreprise_id','=','ent.id')
                    ->join('prefecture as pref','pref.code','=','rep.prefecture_code')
                    ->select(
                        'ent.*',
                        'br.id','br.libelle as activite_principale_libelle',
                        'com.id','com.libelle as commune_entreprise_libelle',
                        'preff.id','preff.libelle as entreprise_prefecture',
                        'rep.*',
                        'pref.id','pref.libelle as representant_prefecture',
                        )
                    ->get();

        // $data = Entreprise::select('*')
        //             ->with(['representants' => function ($q) {
        //                 $q->join('prefecture as p', 'representants.prefecture_code', '=', 'p.code')
        //                     ->select('p.*');
        //             }])->get();

        // $aff = Entreprise::with('representants','prefectures')->get();

        return response()->json([
            'data' => $data
        ], 200);
    }
}
