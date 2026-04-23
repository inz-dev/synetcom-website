<?php

namespace App\Http\Middleware;
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
    public function share(Request $request): array
    {
        /*     $tests =Telephones::select('id_telephone')->orderBy('created_at', 'asc')->skip(2)->take(1)->get()[0]['id_telephone'];
 dd('$tests', $tests); */
        return [
            ...parent::share($request),
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

        ];
    }
}
