<?php

namespace App\Http\Controllers;

use App\Models\Emails;
use App\Models\Organismes;
use App\Models\Telephones;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrganismesController extends Controller
{
    public function index()
    {
        return Inertia::render('Organisme/Index', [
            'organisme'  => Organismes::first(),
            'telephones' => Telephones::orderBy('created_at')->get(),
            'emails'     => Emails::orderBy('created_at')->get(),
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
}
