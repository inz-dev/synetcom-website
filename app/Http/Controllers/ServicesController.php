<?php

namespace App\Http\Controllers;

use App\Models\Services;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ServicesController extends Controller
{
    public function index()
    {
        $services = Services::with('departements')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn($s) => [
                'id'          => $s->id_service,
                'title'       => $s->nom_service,
                'desc'        => $s->description_service,
                'color'       => $s->color ?? '#1b449c',
                'paths'       => $s->paths ?? [],
                'departement' => $s->departements?->nom_departement,
            ]);

        return Inertia::render('Services/Index', compact('services'));
    }

    public function create() {}

    public function store(Request $request)
    {
        $request->validate([
            'nom_service'    => 'required|string|min:2',
            'departement_id' => 'required|exists:departements,id_departement',
        ], [
            'nom_service.required'    => 'Veuillez entrer le nom du service.',
            'nom_service.min'         => 'Minimum 2 caractères.',
            'departement_id.required' => 'Le département est requis.',
            'departement_id.exists'   => 'Département invalide.',
        ]);

        Services::create([
            'nom_service'         => $request->nom_service,
            'description_service' => $request->description_service,
            'icon_service'        => $request->icon_service,
            'color'               => $request->color ?? '#1b449c',
            'paths'               => $request->paths ?? [],
            'departement_id'      => $request->departement_id,
        ]);

        return redirect()->route('departements')->with([
            'message' => 'Service ajouté avec succès !',
            'type'    => 'success',
        ]);
    }

    public function show(Services $services) {}

    public function edit(Services $services) {}

    public function update(Request $request, $id)
    {
        $service = Services::findOrFail($id);

        $request->validate([
            'nom_service' => 'required|string|min:2',
        ], [
            'nom_service.required' => 'Veuillez entrer le nom du service.',
            'nom_service.min'      => 'Minimum 2 caractères.',
        ]);

        $service->update([
            'nom_service'         => $request->nom_service,
            'description_service' => $request->description_service,
            'icon_service'        => $request->icon_service,
            'color'               => $request->color ?? $service->color,
            'paths'               => $request->paths ?? $service->paths,
        ]);

        return redirect()->route('departements')->with([
            'message' => 'Service modifié avec succès !',
            'type'    => 'success',
        ]);
    }

    public function destroy($id)
    {
        $service = Services::findOrFail($id);
        $service->delete();

        return redirect()->route('departements')->with([
            'message' => 'Service supprimé avec succès !',
            'type'    => 'success',
        ]);
    }
}
