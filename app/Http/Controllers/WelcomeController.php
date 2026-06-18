<?php

namespace App\Http\Controllers;

use App\Models\Pages;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Foundation\Application;

class WelcomeController extends Controller
{
    public function index()
    {
        $page = Pages::where('titre_page', 'Accueil')
            ->with(['sections' => fn($q) => $q->with('cards')])
            ->first();

        $stats = [];
        $ctas  = [];

        if ($page) {
            $statsSection = $page->sections->firstWhere('nom_section', 'Chiffres clés');
            if ($statsSection) {
                $stats = $statsSection->cards->map(fn($c) => [
                    'valeur' => $c->titre_card,
                    'label'  => $c->description_card,
                ])->values()->toArray();
            }

            $ctaSection = $page->sections->firstWhere('nom_section', 'Appels à l\'action');
            if ($ctaSection) {
                $ctas = $ctaSection->cards->map(fn($c) => [
                    'texte' => $c->titre_card,
                    'url'   => $c->titre_bouton_card ?? '#',
                ])->values()->toArray();
            }
        }

        return Inertia::render('Welcome', [
            'canLogin'    => Route::has('login'),
            'canRegister' => Route::has('register'),
            'page'        => $page ? [
                'titre_page'       => $page->titre_page,
                'slogan_page'      => $page->slogan_page,
                'description_page' => $page->description_page,
                'banniere_page'    => $page->banniere_page,
                'stats'            => $stats,
                'ctas'             => $ctas,
                'sections'         => $page->sections->map(fn($s) => [
                    'nom_section'         => $s->nom_section,
                    'description_section' => $s->description_section,
                    'icon_section'        => $s->icon_section,
                ])->values(),
            ] : null,
        ]);
    }
}
