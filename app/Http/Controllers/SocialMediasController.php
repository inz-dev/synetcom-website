<?php

namespace App\Http\Controllers;

use App\Models\Emails;
use App\Models\Employes;
use App\Models\EmployesHasSocialMedias;
use App\Models\SocialMedias;
use App\Models\Telephones;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SocialMediasController extends Controller
{
    public function index()
    {
        $socialMedias = SocialMedias::with(['telephones', 'emails', 'employes'])
            ->get()
            ->map(fn($sm) => [
                'id_social_media'   => $sm->id_social_media,
                'nom_social_media'  => $sm->nom_social_media,
                'lien_social_media' => $sm->lien_social_media,
                'logo_social_media' => $sm->logo_social_media,
                'is_mobile'         => $sm->is_mobile,
                'telephone'         => $sm->telephones ? [
                    'id_telephone'   => $sm->telephones->id_telephone,
                    'code_telephone' => $sm->telephones->code_telephone,
                    'telephone'      => $sm->telephones->telephone,
                ] : null,
                'email' => $sm->emails ? [
                    'id_email' => $sm->emails->id_email,
                    'email'    => $sm->emails->email,
                ] : null,
                'employes' => $sm->employes->map(fn($e) => [
                    'id_employe'  => $e->id_employe,
                    'nom_employe' => $e->nom_employe,
                ]),
            ]);

        $employes = Employes::orderBy('nom_employe')
            ->get(['id_employe', 'nom_employe']);

        return Inertia::render('Employes/SocialMedias', [
            'allSocialMedias' => $socialMedias,
            'allEmployes'     => $employes,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_social_media'  => 'required|string',
            'lien_social_media' => 'nullable|string',
            'is_mobile'         => 'boolean',
            'code_telephone'    => 'nullable|string',
            'telephone'         => 'nullable|string',
            'email'             => 'nullable|email',
        ]);

        $id_telephone = null;
        $id_email     = null;

        if ($request->filled('telephone')) {
            $phone        = Telephones::create([
                'code_telephone' => $request->code_telephone ?? '+227',
                'telephone'      => $request->telephone,
            ]);
            $id_telephone = $phone->id_telephone;
        }

        if ($request->filled('email')) {
            $emailRec = Emails::create(['email' => $request->email]);
            $id_email = $emailRec->id_email;
        }

        SocialMedias::create([
            'nom_social_media'  => $request->nom_social_media,
            'lien_social_media' => $request->lien_social_media,
            'is_mobile'         => $request->boolean('is_mobile') ? 1 : 0,
            'id_telephone'      => $id_telephone,
            'id_email'          => $id_email,
        ]);

        return redirect()->route('social-medias.index')->with([
            'message' => 'Réseau social créé avec succès !',
            'type'    => 'success',
        ]);
    }

    public function update(Request $request, $id)
    {
        $sm = SocialMedias::findOrFail($id);

        $request->validate([
            'nom_social_media'  => 'required|string',
            'lien_social_media' => 'nullable|string',
            'is_mobile'         => 'boolean',
            'code_telephone'    => 'nullable|string',
            'telephone'         => 'nullable|string',
            'email'             => 'nullable|email',
        ]);

        if ($request->filled('telephone')) {
            if ($sm->id_telephone) {
                Telephones::find($sm->id_telephone)?->update([
                    'code_telephone' => $request->code_telephone ?? '+227',
                    'telephone'      => $request->telephone,
                ]);
            } else {
                $phone            = Telephones::create([
                    'code_telephone' => $request->code_telephone ?? '+227',
                    'telephone'      => $request->telephone,
                ]);
                $sm->id_telephone = $phone->id_telephone;
            }
        } elseif ($request->has('telephone') && !$request->filled('telephone')) {
            $sm->id_telephone = null;
        }

        if ($request->filled('email')) {
            if ($sm->id_email) {
                Emails::find($sm->id_email)?->update(['email' => $request->email]);
            } else {
                $emailRec     = Emails::create(['email' => $request->email]);
                $sm->id_email = $emailRec->id_email;
            }
        } elseif ($request->has('email') && !$request->filled('email')) {
            $sm->id_email = null;
        }

        $sm->update([
            'nom_social_media'  => $request->nom_social_media,
            'lien_social_media' => $request->lien_social_media,
            'is_mobile'         => $request->boolean('is_mobile') ? 1 : 0,
            'id_telephone'      => $sm->id_telephone,
            'id_email'          => $sm->id_email,
        ]);

        return redirect()->route('social-medias.index')->with([
            'message' => 'Réseau social modifié avec succès !',
            'type'    => 'success',
        ]);
    }

    public function destroy($id)
    {
        $sm = SocialMedias::findOrFail($id);
        EmployesHasSocialMedias::where('id_social_media', $sm->id_social_media)->delete();
        $sm->delete();

        return redirect()->route('social-medias.index')->with([
            'message' => 'Réseau social supprimé avec succès !',
            'type'    => 'success',
        ]);
    }

    public function assignToEmployee(Request $request)
    {
        $request->validate([
            'id_employe'      => 'required|string|exists:employes,id_employe',
            'id_social_media' => 'required|string|exists:social_medias,id_social_media',
        ]);

        $exists = EmployesHasSocialMedias::where('id_employe', $request->id_employe)
            ->where('id_social_media', $request->id_social_media)
            ->exists();

        if (!$exists) {
            EmployesHasSocialMedias::create([
                'id_employe'                      => $request->id_employe,
                'id_social_media'                 => $request->id_social_media,
                'actif_employes_has_social_media' => 1,
            ]);
        }

        return back()->with(['message' => 'Réseau social assigné avec succès !', 'type' => 'success']);
    }

    public function removeFromEmployee(Request $request)
    {
        $request->validate([
            'id_employe'      => 'required|string',
            'id_social_media' => 'required|string',
        ]);

        EmployesHasSocialMedias::where('id_employe', $request->id_employe)
            ->where('id_social_media', $request->id_social_media)
            ->delete();

        return back()->with(['message' => 'Réseau social retiré avec succès !', 'type' => 'success']);
    }
}
