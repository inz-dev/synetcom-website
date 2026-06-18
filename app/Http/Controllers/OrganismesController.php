<?php

namespace App\Http\Controllers;

use App\Models\Emails;
use App\Models\Organismes;
use App\Models\Telephones;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class OrganismesController extends Controller
{
    public function index(){
            $organisme =Organismes::with(['socialMedias.telephones', 'socialMedias.emails'])
            ->get()
            ->map(fn($e) => [
                'id_organisme'            => $e->id_organisme,
                'nom_organisme'           => $e->nom_organisme,
                'logo_organisme'        => $e->logo_organisme,
                 'lien_map_organisme'        => $e->lien_map_organisme,
                'adresse_organisme'       => $e->adresse_organisme,
                'slogan_organisme'          => $e->slogan_organisme,
                'social_medias' => $e->socialMedias->map(fn($sm) => [

                    'id_social_media'   => $sm->id_social_media,
                    'nom_social_media'  => $sm->nom_social_media,
                    'lien_social_media' => $sm->lien_social_media,
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
                ]),
            ]);
//dd("organisme:", $organisme);

        return Inertia::render('Organisme/Index', [
            'organisme' => $organisme,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $organisme = Organismes::where('id_organisme', $id)->firstOrFail();

        $validated = $request->validate([
            'nom_organisme'      => 'required|string|max:255',
            'adresse_organisme'  => 'required|string|max:500',
            'slogan_organisme'   => 'required|string|max:500',
            'lien_map_organisme' => 'nullable|string|max:500',
        ]);

        $organisme->update($validated);

        return back()->with('flash', ['type' => 'success', 'message' => 'Informations mises à jour.']);
    }

    public function storeTelephone(Request $request)
    {
        $validated = $request->validate([
            'code_telephone' => 'required|string|max:10',
            'telephone'      => 'required|numeric|unique:telephones,telephone',
        ]);

        Telephones::create($validated);

        return back()->with('flash', ['type' => 'success', 'message' => 'Numéro ajouté.']);
    }

    public function destroyTelephone(string $id)
    {
        Telephones::where('id_telephone', $id)->firstOrFail()->delete();

        return back()->with('flash', ['type' => 'success', 'message' => 'Numéro supprimé.']);
    }

    public function storeEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255|unique:emails,email',
        ]);

        Emails::create(['email' => $request->email]);

        return back()->with('flash', ['type' => 'success', 'message' => 'Email ajouté.']);
    }

    public function destroyEmail(string $id)
    {
        Emails::where('id_email', $id)->firstOrFail()->delete();

        return back()->with('flash', ['type' => 'success', 'message' => 'Email supprimé.']);
    }

    public function updateLogo(Request $request, string $id)
    {
        $request->validate([
            'logo' => 'required|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
        ]);

        $organisme = Organismes::where('id_organisme', $id)->firstOrFail();

        $dir = public_path('images/logos');
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        if ($organisme->logo_organisme) {
            $old = public_path($organisme->logo_organisme);
            if (file_exists($old)) {
                unlink($old);
            }
        }

        $file     = $request->file('logo');
        $filename = 'logo_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
        $file->move($dir, $filename);

        $organisme->update(['logo_organisme' => '/images/logos/' . $filename]);

        return back()->with('flash', ['type' => 'success', 'message' => 'Logo mis à jour.']);
    }
}
