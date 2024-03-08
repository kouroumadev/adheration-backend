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
                    ->join('representants as rep','rep.entreprise_id','=','ent.id')
                    ->join('prefecture as pref','pref.code','=','rep.prefecture_code')
                    ->select('ent.*','rep.*','pref.*')
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
