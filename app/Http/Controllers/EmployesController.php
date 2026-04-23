<?php

namespace App\Http\Controllers;

use App\Models\Departements;
use App\Models\Employes;
use App\Models\Postes;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class EmployesController extends Controller
{
    public function index()
    {
        $employes = Employes::with(['latestPoste.departements', 'user'])
            ->get()
            ->map(fn($e) => [
                'id_employe'            => $e->id_employe,
                'nom_employe'           => $e->nom_employe,
                'profil_employe'        => $e->profil_employe,
                'adresse_employe'       => $e->adresse_employe,
                'date_embauche_employe' => optional($e->date_embauche_employe)->format('Y-m-d'),
                'type_contrat'          => $e->type_contrat,
                'poste'                 => $e->latestPoste ? [
                    'id_poste'         => $e->latestPoste->id_poste,
                    'nom_poste'        => $e->latestPoste->nom_poste,
                    'id_departement'   => $e->latestPoste->id_departement,
                    'departement'      => optional($e->latestPoste->departements)->nom_departement,
                ] : null,
                'user'                  => $e->user ? [
                    'id'    => $e->user->id,
                    'email' => $e->user->email,
                ] : null,
            ]);

        $departements = Departements::orderBy('nom_departement')
            ->get(['id_departement', 'nom_departement']);

        return Inertia::render('Employes/Index.employes', [
            'allEmployes'     => $employes,
            'allDepartements' => $departements,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_employe'           => 'required|string|min:2',
            'profil_employe'        => 'required|string',
            'adresse_employe'       => 'nullable|string',
            'date_embauche_employe' => 'required|date',
            'type_contrat'          => 'required|string',
            'nom_poste'             => 'nullable|string|min:2',
            'id_departement'        => 'nullable|string|exists:departements,id_departement',
            'creer_compte'          => 'boolean',
        ], [
            'nom_employe.required'           => "Le nom est obligatoire.",
            'profil_employe.required'        => 'Le profil est obligatoire.',
            'date_embauche_employe.required' => "La date d'embauche est obligatoire.",
            'type_contrat.required'          => 'Le type de contrat est obligatoire.',
        ]);

        $employe = Employes::create([
            'nom_employe'           => $request->nom_employe,
            'profil_employe'        => $request->profil_employe,
            'adresse_employe'       => $request->adresse_employe,
            'date_embauche_employe' => $request->date_embauche_employe,
            'type_contrat'          => $request->type_contrat,
        ]);

        if ($request->nom_poste && $request->id_departement) {
            Postes::create([
                'nom_poste'        => $request->nom_poste,
                'id_employe'       => $employe->id_employe,
                'id_departement'   => $request->id_departement,
                'type_contrat'     => $request->type_contrat,
                'date_debut_poste' => $request->date_embauche_employe,
                'date_fin_poste'   => '9999-12-31',
            ]);
        }

        if ($request->boolean('creer_compte')) {
            $user = $this->createEmployeeAccount($employe);
            $employe->update(['user_id' => $user->id]);
        }

        return redirect()->route('employes')->with([
            'message' => "Employe cree avec succes !",
            'type'    => 'success',
        ]);
    }

    public function update(Request $request, $id)
    {
        $employe = Employes::findOrFail($id);

        $request->validate([
            'nom_employe'           => 'required|string|min:2',
            'profil_employe'        => 'required|string',
            'adresse_employe'       => 'nullable|string',
            'date_embauche_employe' => 'required|date',
            'type_contrat'          => 'required|string',
            'nom_poste'             => 'nullable|string|min:2',
            'id_departement'        => 'nullable|string|exists:departements,id_departement',
            'creer_compte'          => 'boolean',
            'reset_password'        => 'boolean',
        ], [
            'nom_employe.required'    => "Le nom est obligatoire.",
            'profil_employe.required' => 'Le profil est obligatoire.',
        ]);

        $employe->update([
            'nom_employe'           => $request->nom_employe,
            'profil_employe'        => $request->profil_employe,
            'adresse_employe'       => $request->adresse_employe,
            'date_embauche_employe' => $request->date_embauche_employe,
            'type_contrat'          => $request->type_contrat,
        ]);

        if ($request->nom_poste && $request->id_departement) {
            $latest = $employe->fresh()->latestPoste;
            if ($latest) {
                $latest->update([
                    'nom_poste'      => $request->nom_poste,
                    'id_departement' => $request->id_departement,
                    'type_contrat'   => $request->type_contrat,
                ]);
            } else {
                Postes::create([
                    'nom_poste'        => $request->nom_poste,
                    'id_employe'       => $employe->id_employe,
                    'id_departement'   => $request->id_departement,
                    'type_contrat'     => $request->type_contrat,
                    'date_debut_poste' => $request->date_embauche_employe,
                    'date_fin_poste'   => '9999-12-31',
                ]);
            }
        }

        if ($request->boolean('creer_compte') && !$employe->user_id) {
            $user = $this->createEmployeeAccount($employe);
            $employe->update(['user_id' => $user->id]);
        }

        if ($request->boolean('reset_password') && $employe->user_id) {
            optional(User::find($employe->user_id))->update(['password' => Hash::make('password')]);
        }

        return redirect()->route('employes')->with([
            'message' => 'Employe modifie avec succes !',
            'type'    => 'success',
        ]);
    }

    public function destroy($id)
    {
        $employe = Employes::findOrFail($id);
        $employe->postes()->delete();
        $employe->delete();

        return redirect()->route('employes')->with([
            'message' => 'Employe supprime avec succes !',
            'type'    => 'success',
        ]);
    }

    private function createEmployeeAccount(Employes $employe): User
    {
        $parts     = preg_split('/\s+/', trim($employe->nom_employe), 2);
        $firstname = $parts[0] ?? $employe->nom_employe;
        $lastname  = $parts[1] ?? '';

        $acc = [
            "\xc3\xa0"=>'a', "\xc3\xa2"=>'a', "\xc3\xa4"=>'a',
            "\xc3\xa9"=>'e', "\xc3\xa8"=>'e', "\xc3\xaa"=>'e', "\xc3\xab"=>'e',
            "\xc3\xae"=>'i', "\xc3\xaf"=>'i', "\xc3\xb4"=>'o', "\xc3\xb6"=>'o',
            "\xc3\xb9"=>'u', "\xc3\xbb"=>'u', "\xc3\xbc"=>'u', "\xc3\xa7"=>'c',
            "\xc3\x80"=>'a', "\xc3\x82"=>'a', "\xc3\x84"=>'a',
            "\xc3\x89"=>'e', "\xc3\x88"=>'e', "\xc3\x8a"=>'e', "\xc3\x8b"=>'e',
            "\xc3\x8e"=>'i', "\xc3\x8f"=>'i', "\xc3\x94"=>'o', "\xc3\x96"=>'o',
            "\xc3\x99"=>'u', "\xc3\x9b"=>'u', "\xc3\x9c"=>'u', "\xc3\x87"=>'c',
        ];
        $clean = fn($s) => preg_replace('/[^a-z0-9]/', '', strtolower(strtr($s, $acc)));

        $base  = $clean($firstname) . '.' . $clean($lastname);
        $email = $base . '@synetcom-niger.com';

        $counter = 1;
        while (User::where('email', $email)->exists()) {
            $email = $base . $counter . '@synetcom-niger.com';
            $counter++;
        }

        return User::create([
            'lastname'  => strtoupper($lastname) ?: strtoupper($firstname),
            'firstname' => $firstname,
            'sex'       => 'M',
            'email'     => $email,
            'password'  => Hash::make('password'),
        ]);
    }
}
