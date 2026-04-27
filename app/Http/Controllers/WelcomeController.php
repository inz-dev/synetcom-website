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

        return Inertia::render('Welcome', [
            'canLogin'    => Route::has('login'),
            'canRegister' => Route::has('register'),
            'page'        => $page ? [
                'slogan_page' => $page->slogan_page,
                'sections'    => $page->sections->map(fn($s) => [
                    'nom_section'         => $s->nom_section,
                    'description_section' => $s->description_section,
                    'icon_section'        => $s->icon_section,
                ])->values(),
            ] : null,
        ]);
    }
}
