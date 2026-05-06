<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Pages;
use App\Models\Sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Webpatser\Uuid\Uuid;

class PagesController extends Controller
{
    public function index()
    {
        $pages = Pages::with(['sections' => function ($q) {
            $q->with('cards');
        }])->get()->map(fn($p) => [
            'id_page'          => $p->id_page,
            'titre_page'       => $p->titre_page,
            'slogan_page'      => $p->slogan_page,
            'banniere_page'    => $p->banniere_page,
            'description_page' => $p->description_page,
            'sections'         => $p->sections->map(fn($s) => [
                'id_section'          => $s->id_section,
                'nom_section'         => $s->nom_section,
                'description_section' => $s->description_section,
                'icon_section'        => $s->icon_section,
                'is_link_section'     => (bool) $s->is_link_section,
                'cards'               => $s->cards->map(fn($c) => [
                    'id_card'           => $c->id_card,
                    'titre_card'        => $c->titre_card,
                    'description_card'  => $c->description_card,
                    'icon_card'         => $c->icon_card,
                    'titre_bouton_card' => $c->titre_bouton_card,
                ])->values(),
            ])->values(),
        ])->values();
  //dd('allPages:', $pages);
        return Inertia::render('Pages/Index.pages', [
            'allPages' => $pages,
        ]);

    }

    // ── Pages CRUD ───────────────────────────────────────────────

    public function store(Request $request)
    {
        $request->validate([
            'titre_page'       => 'required|string|min:2',
            'slogan_page'      => 'nullable|string|max:255',
            'banniere_page'    => 'nullable|image|max:5120',
            'description_page' => 'nullable|string',
        ], [
            'titre_page.required'  => 'Le titre de la page est obligatoire.',
            'banniere_page.image'  => 'Le fichier doit être une image.',
            'banniere_page.max'    => 'L\'image ne doit pas dépasser 5 Mo.',
        ]);

        $bannierePath = null;
        if ($request->hasFile('banniere_page')) {
            $bannierePath = $this->storeBannerFile($request->file('banniere_page'));
        }

        Pages::create([
            'titre_page'       => $request->titre_page,
            'slogan_page'      => $request->slogan_page,
            'banniere_page'    => $bannierePath,
            'description_page' => $request->description_page,
        ]);

        return redirect()->route('pages')->with([
            'message' => "Page « {$request->titre_page} » créée avec succès !",
            'type'    => 'success',
        ]);
    }

    public function update(Request $request, $page)
    {
        $record = Pages::findOrFail($page);

        $request->validate([
            'titre_page'       => 'required|string|min:2',
            'slogan_page'      => 'nullable|string|max:255',
            'banniere_page'    => 'nullable|image|max:5120',
            'description_page' => 'nullable|string',
        ], [
            'titre_page.required'  => 'Le titre de la page est obligatoire.',
            'banniere_page.image'  => 'Le fichier doit être une image.',
            'banniere_page.max'    => 'L\'image ne doit pas dépasser 5 Mo.',
        ]);

        $bannierePath = $record->banniere_page;
        if ($request->hasFile('banniere_page')) {
            $bannierePath = $this->storeBannerFile($request->file('banniere_page'));
        }

        $record->update([
            'titre_page'       => $request->titre_page,
            'slogan_page'      => $request->slogan_page,
            'banniere_page'    => $bannierePath,
            'description_page' => $request->description_page,
        ]);

        return redirect()->route('pages')->with([
            'message' => 'Page mise à jour avec succès !',
            'type'    => 'success',
        ]);
    }

    private function storeBannerFile($file): string
    {
        $dir = public_path('images/bannieres');
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }
        $filename = 'page_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
        $file->move($dir, $filename);
        return '/images/bannieres/' . $filename;
    }

    public function destroy($page)
    {
        $record = Pages::findOrFail($page);
        $record->delete();

        return redirect()->route('pages')->with([
            'message' => 'Page supprimée avec succès !',
            'type'    => 'success',
        ]);
    }

    // ── Sections CRUD ────────────────────────────────────────────

    public function storeSection(Request $request)
    {
        $request->validate([
            'nom_section'         => 'required|string|min:2',
            'description_section' => 'nullable|string',
            'icon_section'        => 'nullable|string|max:100',
            'is_link_section'     => 'boolean',
            'id_page'             => 'required|string|exists:pages,id_page',
        ], [
            'nom_section.required' => 'Le nom de la section est obligatoire.',
            'id_page.required'     => 'La page associée est obligatoire.',
            'id_page.exists'       => 'La page sélectionnée est invalide.',
        ]);

        $section = Sections::create([
            'nom_section'         => $request->nom_section,
            'description_section' => $request->description_section,
            'icon_section'        => $request->icon_section,
            'is_link_section'     => $request->is_link_section ? 1 : 0,
        ]);

        DB::table('pages_has_sections')->insert([
            'id_pages_has_sections' => Uuid::generate()->string,
            'id_page'               => $request->id_page,
            'id_section'            => $section->id_section,
            'created_at'            => now(),
            'updated_at'            => now(),
        ]);

        return redirect()->route('pages')->with([
            'message' => "Section « {$request->nom_section} » créée avec succès !",
            'type'    => 'success',
        ]);
    }

    public function updateSection(Request $request, $section)
    {
        $record = Sections::findOrFail($section);

        $request->validate([
            'nom_section'         => 'required|string|min:2',
            'description_section' => 'nullable|string',
            'icon_section'        => 'nullable|string|max:100',
            'is_link_section'     => 'boolean',
        ], [
            'nom_section.required' => 'Le nom de la section est obligatoire.',
        ]);

        $record->update([
            'nom_section'         => $request->nom_section,
            'description_section' => $request->description_section,
            'icon_section'        => $request->icon_section,
            'is_link_section'     => $request->is_link_section ? 1 : 0,
        ]);

        return redirect()->route('pages')->with([
            'message' => 'Section mise à jour avec succès !',
            'type'    => 'success',
        ]);
    }

    public function destroySection($section)
    {
        $record = Sections::findOrFail($section);
        $record->delete();

        return redirect()->route('pages')->with([
            'message' => 'Section supprimée avec succès !',
            'type'    => 'success',
        ]);
    }

    // ── Cards CRUD ───────────────────────────────────────────────

    public function storeCard(Request $request)
    {
        $request->validate([
            'titre_card'        => 'required|string|min:2',
            'description_card'  => 'nullable|string',
            'icon_card'         => 'nullable|string|max:100',
            'titre_bouton_card' => 'nullable|string|max:100',
            'id_section'        => 'required|string|exists:sections,id_section',
        ], [
            'titre_card.required'  => 'Le titre de la carte est obligatoire.',
            'id_section.required'  => 'La section associée est obligatoire.',
            'id_section.exists'    => 'La section sélectionnée est invalide.',
        ]);

        $card = Card::create([
            'titre_card'        => $request->titre_card,
            'description_card'  => $request->description_card,
            'icon_card'         => $request->icon_card,
            'titre_bouton_card' => $request->titre_bouton_card,
        ]);

        DB::table('sections_has_cards')->insert([
            'id_sections_has_cards' => Uuid::generate()->string,
            'id_section'            => $request->id_section,
            'id_card'               => $card->id_card,
            'created_at'            => now(),
            'updated_at'            => now(),
        ]);

        return redirect()->route('pages')->with([
            'message' => "Carte « {$request->titre_card} » créée avec succès !",
            'type'    => 'success',
        ]);
    }

    public function updateCard(Request $request, $card)
    {
        $record = Card::findOrFail($card);

        $request->validate([
            'titre_card'        => 'required|string|min:2',
            'description_card'  => 'nullable|string',
            'icon_card'         => 'nullable|string|max:100',
            'titre_bouton_card' => 'nullable|string|max:100',
        ], [
            'titre_card.required' => 'Le titre de la carte est obligatoire.',
        ]);

        $record->update([
            'titre_card'        => $request->titre_card,
            'description_card'  => $request->description_card,
            'icon_card'         => $request->icon_card,
            'titre_bouton_card' => $request->titre_bouton_card,
        ]);

        return redirect()->route('pages')->with([
            'message' => 'Carte mise à jour avec succès !',
            'type'    => 'success',
        ]);
    }

    public function destroyCard($card)
    {
        $record = Card::findOrFail($card);
        $record->delete();

        return redirect()->route('pages')->with([
            'message' => 'Carte supprimée avec succès !',
            'type'    => 'success',
        ]);
    }
}
