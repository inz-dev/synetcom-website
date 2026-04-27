<?php

namespace App\Http\Controllers;

use App\Models\Pages;
use App\Models\Team;
use Inertia\Inertia;

class TeamController extends Controller
{
    public function index()
    {
        $members = Team::with([
            'employe.latestPoste',
            'employe.socialMedias',
        ])
        ->orderBy('ordre')
        ->get()
        ->map(fn($t) => [
            'id'         => $t->id,
            'image'      => $t->image_team,
            'bio'        => $t->bio_team,
            'badge'      => $t->badge_team,
            'badgeColor' => $t->badge_color_team,
            'id_employe' => $t->id_employe,
            'name'       => $t->employe?->nom_employe ?? $t->name_team,
            'role'       => $t->employe?->latestPoste?->nom_poste,
            'socials'    => $t->employe?->socialMedias->map(fn($s) => [
                'nom'  => $s->nom_social_media,
                'lien' => $s->lien_social_media,
                'logo' => $s->logo_social_media,
            ])->values() ?? [],
        ])
        ->values();

        return Inertia::render('Equipe/Index', [
            'members' => $members,
            'page'    => Pages::forPage('Équipe'),
        ]);
    }
}
