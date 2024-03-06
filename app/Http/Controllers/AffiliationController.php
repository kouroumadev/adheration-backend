<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use App\Models\EmailVerification;
use Illuminate\Http\Request;
use App\Mail\AffMail;
use App\Models\Entreprise;
use App\Models\Representant;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Drivers\Gd\Driver;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class AffiliationController extends Controller
{
    public function sendEmail(){
        $code = rand(0000 , 9999);
        // $email = "kouroumadev@gmail.com";
        $email = "rsagno69@gmail.com";
        $prenom = "abdoul Karim";
        Mail::to($email)->send(new AffMail($code,$email,$prenom));

        return response()->json("success", 200);

    }

    public function getCommunes(){
        $data = DB::table('communes')->get();
        return response()->json($data, 200);
    }

    public function getPrefectures(){
        $data = DB::table('prefecture')->get();
        return response()->json($data, 200);
    }
    public function getBranches(){
        $data = DB::table('branche')->get();
        return response()->json($data, 200);
    }

    public function AffStore(Request $request){
        // dd($request->i_fiscale);
        $categorie = '';
        $code = Str::upper(Str::random(13));
        $existe = Entreprise::where('raison_sociale',$request->raison_sociale)->get();
        $sigleImage = $request->file('sigle');
        $rccmFile= $request->file('rccm_file');
        $ndniFile= $request->file('num_impot_file');
        // dd($ndniFile);

        if($request->has('sigle')){
            $file = $request->file('sigle')->getClientOriginalName();
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $extension = pathinfo($file, PATHINFO_EXTENSION);

            $img = $filename."-".time()."-".$request->no_ima_employee.".".$extension;

            Storage::disk('affiliationImgs')->put($img,file_get_contents($request->file('sigle')));
        }

        if($request->has('rccm_file')){

        }

        if($request->has('num_impot_file')){

        }

        $save_img =''; $rccm_path =''; $ndni_path ='';
        if ($rccmFile) {
            $destination_path = 'upload/entreprise_doc';
            $file_name = $rccmFile->getClientOriginalName();
            $uniqueName = uniqid().'rccm'.'.'.'pdf';
            $rccm_path = $rccmFile->move($destination_path,$uniqueName);
        }
        if ($ndniFile) {
            $destination_path = 'upload/entreprise_doc';
            $file_name = $ndniFile->getClientOriginalName();
            $uniqueName = uniqid().'ndni'.'.'.'pdf';
            $ndni_path = $ndniFile->move($destination_path,$uniqueName);
        }

        if($sigleImage){
            $manager = ImageManager::withDriver(new Driver());
            $filename = $sigleImage->getClientOriginalName();
            $unique = uniqid()."_".$filename;
            $img = $manager->read($sigleImage);
            $taille = $img->resize(500,500);
            $taille->toJpeg(80)->save(base_path('public/upload/sigle/'.$unique));
            $save_img = 'upload/sigle/'.$unique;


        }



        if ($request->nombre_emp > 20) {
            $categorie = "E+20";
        } else {
            $categorie = "E-20";
        }
        // dd($categorie);
        //   dd(sizeof($existe));
        if (sizeof($existe) == 1) {
            $data = "Ce Nom d'entreprise a été déclaré veillez changer le nom";
            return response()->json($data, 404);

        } else {
            $entreprise = new Entreprise();

                 $entreprise->num_agrement = $request->num_agrement;
                 $entreprise->raison_sociale = $request->raison_sociale;
                 $entreprise->num_impot = $request->num_impot;
                 $entreprise->activite_principale = $request->activite_principale;
                 $entreprise->quartier_entreprise = $request->quartier_entreprise;
                 $entreprise->commune_entreprise = $request->commune_entreprise;
                  $entreprise->ville_entreprise =$request->ville_entreprise;
                  $entreprise->nombre_emp =$request->nombre_emp;
                // efectif_homme =$request->effectif_homme;
                // efectif_femme =$request->effectif_femme;
                 $entreprise->boite_postale =$request->boite_postale;
                 $entreprise->categorie =$categorie;
                 $entreprise->sigle =$save_img;
                 $entreprise->rccm_file =$rccm_path;
                 $entreprise->num_impot_file =$ndni_path;

                 $entreprise->save();

                 $entreprise_id = $entreprise->id;

            // // dd($entreprise);
            // ////// Representant store
            $representant = new Representant();
             $representant->prenom =  $request->prenom;
             $representant->nom =  $request->nom;
             $representant->document_identite =  $request->document_identite;
                // 'ville_representant =  $request->ville_representant;
             $representant->email =  $request->email;
             $representant->telephone_representant = $request->telephone_representant;
             $representant->adresse_representant = $request->adresse_representant;
             $representant->entreprise_id =  $entreprise_id;
            //  $representant->created_at =  Carbon::now();
             $representant->save();
             $representant_id = $representant->id;


            // $representant = Representant::insertGetId([
            //     'prenom' => $request->prenom;
            //     'nom' => $request->nom,
            //     'document_identite' => $request->document_identite,
            //     // 'ville_representant' => $request->ville_representant,
            //     'email' => $request->email,
            //     'telephone_representant' =>$request->telephone_representant,
            //     'adresse_representant' =>$request->adresse_representant,
            //     'entreprise_id' => $entreprise,
            //     'created_at' => Carbon::now()
            // ]);
            // // dd($representant);
            // ///// Demande store

            $demande = new Demande();
            $demande->representant_id = $request->representant_id;
            $demande->entreprise_id = $request->entreprise_id;
            $demande->type_demande = "affiliation";
            $demande->code_demande = $code;
            $demande->save();

            // $demande = Demande::create([
            //     'representant_id' => $representant_id,
            //     'entreprise_id' => $entreprise_id,
            //     'type_demande' => "affiliation",
            //     'code_demande' => $code,
            // ]);

            return view('pages.confirmation-affiliation',compact('demande'));
        }


    }
}
