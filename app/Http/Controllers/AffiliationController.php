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
        // dd($request->data);

        $sigle = $request->data['sigle'];
        $photo = $request->data['photo'];
        $num_impot_file = $request->data['num_impot_file'];
        $document = $request->data['document'];
        $rccm_file = $request->data['rccm_file'];
        $nombre_emp = $request->data['nombre_emp'];
        $email = explode(".",$request->data['email']);

         $categorie = '';
         $code = Str::upper(Str::random(13));
         $existe = Entreprise::where('raison_sociale',$request->data['raison_sociale'])->get();


        //STORE SIGLE
        if($sigle != ""){
            // Decode the base64 string
            $image = base64_decode(preg_replace('#^data:([^;]+);base64,#', '', $sigle));

            // Generate a unique file name
            $fileExtension = explode('/', explode(':', substr($sigle, 0, strpos($sigle, ';')))[1])[1];
            $sigle_path = $email['0'].'_' . time() . '.' . $fileExtension;

            Storage::disk('affiliationImgs')->put($sigle_path,$image);

        } else {
            $sigle_path = "";
        }

        // STORE photo
        if($photo != ""){
            // Decode the base64 string
            $image = base64_decode(preg_replace('#^data:([^;]+);base64,#', '', $photo));

            // Generate a unique file name
            $fileExtension = explode('/', explode(':', substr($photo, 0, strpos($photo, ';')))[1])[1];
            $photo_path = $email['0']. '_' . time() . '.' . $fileExtension;

            Storage::disk('affiliationImgs')->put($photo_path,$image);

        } else {
            $photo_path = "";
        }

        // STORE num_impot_file
        if($num_impot_file != ""){
            // Decode the base64 string
            $pdf_file = base64_decode($num_impot_file);

            $impot_path = $email['0'].'_' . time() . 'impot' .$request->data['telephone']. '.pdf';

            // Save the decoded PDF to the specified path
            Storage::disk('public')->put('affiliationDocs/'.$impot_path, $pdf_file);

        } else {
            $impot_path = "";
        }

        // STORE document
        if($document != ""){
            // Decode the base64 string
            $pdf_file = base64_decode($document);

            $doc_path = $email['0'].'_' . time() . 'doc' .$request->data['telephone']. '.pdf';

            // Save the decoded PDF to the specified path
            Storage::disk('public')->put('affiliationDocs/'.$doc_path, $pdf_file);

        } else {
            $doc_path = "";
        }

        // STORE rccm_file
        if($rccm_file != ""){
            // Decode the base64 string
            $pdf_file = base64_decode($rccm_file);

            $rccm_path = $email['0'].'_' . time() . 'rccm' .$request->data['telephone']. '.pdf';

            // Save the decoded PDF to the specified path
            Storage::disk('public')->put('affiliationDocs/'.$rccm_path, $pdf_file);

        } else {
            $rccm_path = "";
        }

        if ($nombre_emp > 20) {
            $categorie = "E+20";
        } else {
            $categorie = "E-20";
        }

        //   dd(sizeof($existe));
        if (sizeof($existe) == 1) {
            return response()->json([
                'message' => "Ce Nom d'entreprise a été déclaré veillez changer le nom"
            ], 404);
        } else {
                $entreprise = new Entreprise();

                $entreprise->num_agrement = $request->data['num_agrement'];
                $entreprise->raison_sociale = $request->data['raison_sociale'];
                $entreprise->num_impot = $request->data['num_impot'];
                $entreprise->activite_principale = $request->data['activite_principale'];
                $entreprise->quartier_entreprise = $request->data['quartier_entreprise'];
                $entreprise->commune_entreprise = $request->data['commune_entreprise'];
                $entreprise->ville_entreprise =$request->data['ville_entreprise'];
                $entreprise->date_creation =$request->data['date_creation'];
                $entreprise->nombre_emp =$nombre_emp;
                $entreprise->efectif_homme =$request->data['efectif_homme'];
                $entreprise->efectif_femme =$request->data['efectif_femme'];
                $entreprise->efectif_apprentis =$request->data['efectif_apprentis'];
                $entreprise->categorie =$categorie;
                $entreprise->sigle =$sigle_path;
                // $entreprise->photo =$photo_path;
                $entreprise->rccm_file =$rccm_path;
                $entreprise->num_impot_file =$impot_path;
                // $entreprise->document =$doc_path;
                $entreprise->save();

                $entreprise_id = $entreprise->id;

            // ////// Representant store
            $representant = new Representant();
            $representant->entreprise_id =  $entreprise_id;
             $representant->prenom =  $request->data['prenom'];
             $representant->nom =  $request->data['nom'];
             $representant->date_naissance =  $request->data['date_naissance'];
             $representant->lieu_naissance =  $request->data['lieu_naissance'];
             $representant->prefecture_code =  $request->data['prefecture_code'];
             $representant->email =  $request->data['email'];
             $representant->telephone = $request->data['telephone'];
             $representant->type_document = $request->data['type_document'];
             $representant->document = $request->$doc_path;
             $representant->photo = $photo_path;

             $representant->save();
             $representant_id = $representant->id;

            $demande = new Demande();
            $demande->entreprise_id = $entreprise_id;
            $demande->representant_id = $representant_id;
            $demande->type_demande = "affiliation";
            $demande->code_demande = $code;
            $demande->save();

            return response()->json([
                'message' => "Affiliation cree avec succes"
            ], 200);
        }


    }
}
