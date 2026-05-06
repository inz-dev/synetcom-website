<?php

namespace App\Http\Middleware;

use App\Models\Emails;
use App\Models\Organismes;
use App\Models\Pages;
use App\Models\Telephones;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';
    protected $withAllErrors = true;

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    private function sharedOrganisme(): ?array
    {
        $org = Organismes::first();
        if (!$org) return null;

        return [
            'id_organisme'      => $org->id_organisme,
            'nom_organisme'     => $org->nom_organisme,
            'adresse_organisme' => $org->adresse_organisme,
            'slogan_organisme'  => $org->slogan_organisme,
            'lien_map_organisme'=> $org->lien_map_organisme,
            'logo_organisme'    => $org->logo_organisme,
            'telephones'        => Telephones::orderBy('created_at')->get(['id_telephone', 'code_telephone', 'telephone']),
            'emails'            => Emails::orderBy('created_at')->get(['id_email', 'email']),
        ];
    }

    public function share(Request $request): array
    {
        /*     $tests =Telephones::select('id_telephone')->orderBy('created_at', 'asc')->skip(2)->take(1)->get()[0]['id_telephone'];
 dd('$tests', $tests); */
        $allPages = Pages::with(['sections' => function ($q) {
            $q->with('cards');
        }])->get()->map(fn($p) => [
            'id_page' => $p->id_page,
            'titre_page' => $p->titre_page,
            'slogan_page' => $p->slogan_page,
            'banniere_page' => $p->banniere_page,
            'description_page' => $p->description_page,
            'sections' => $p->sections->map(fn($s) => [
                'id_section' => $s->id_section,
                'nom_section' => $s->nom_section,
                'description_section' => $s->description_section,
                'icon_section' => $s->icon_section,
                'is_link_section' => $s->is_link_section,
                'cards' => $s->cards->map(fn($c) => [
                    'id_card' => $c->id_card,
                    'titre_card' => $c->titre_card,
                    'description_card' => $c->description_card,
                    'icon_card' => $c->icon_card,
                    'titre_bouton_card' => $c->titre_bouton_card,
                ])->values(),
            ])->values(),
        ])->values();
        //dd(' $allPages: ',  $allPages);
        return [
            ...parent::share($request),
            'allPages' => $allPages,
            'auth' => [
                'user'  => $request->user(),
                'roles' => $request->user() ? $request->user()->getRoleNames() : [],
            ],
            'ziggy' => fn() => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            'flash' => [
                'message' => fn() => $request->session()->get('message'),
                'type' => fn() => $request->session()->get('type', 'success'),
            ],
            'organisme' => fn() => $this->sharedOrganisme(),
        ];
    }
}
