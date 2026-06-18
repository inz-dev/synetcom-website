<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class MediaController extends Controller
{
    private array $folders = [
        'uploads'      => 'Téléchargements',
        'bannieres'    => 'Bannières',
        'logos'        => 'Logos',
        'employes'     => 'Employés',
        'partenaires'  => 'Partenaires',
        'realisations' => 'Réalisations',
    ];

    public function index()
    {
        $extensions = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'];
        $medias     = [];

        foreach ($this->folders as $folder => $label) {
            $dir = public_path('images/' . $folder);
            if (!is_dir($dir)) continue;

            foreach (scandir($dir) as $file) {
                if ($file === '.' || $file === '..') continue;
                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                if (!in_array($ext, $extensions)) continue;

                $fullPath = $dir . DIRECTORY_SEPARATOR . $file;
                $medias[] = [
                    'filename'  => $file,
                    'folder'    => $folder,
                    'label'     => $label,
                    'url'       => '/images/' . $folder . '/' . $file,
                    'size'      => filesize($fullPath),
                    'timestamp' => filemtime($fullPath),
                    'deletable' => $folder === 'uploads',
                ];
            }
        }

        usort($medias, fn($a, $b) => $b['timestamp'] - $a['timestamp']);

        $totalSize = array_sum(array_column($medias, 'size'));

        return Inertia::render('Medias/Index.medias', [
            'medias'    => $medias,
            'totalSize' => $totalSize,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'files'   => 'required|array|max:20',
            'files.*' => 'required|image|mimes:png,jpg,jpeg,webp,gif|max:5120',
        ], [
            'files.required'   => 'Sélectionnez au moins un fichier.',
            'files.*.image'    => 'Chaque fichier doit être une image.',
            'files.*.max'      => 'Chaque image ne doit pas dépasser 5 Mo.',
        ]);

        $dir = public_path('images/uploads');
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        $count = 0;
        foreach ($request->file('files') as $file) {
            $filename = Str::random(8) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $filename);
            $count++;
        }

        return back()->with([
            'message' => $count . ' image(s) uploadée(s) avec succès.',
            'type'    => 'success',
        ]);
    }

    public function destroy(string $filename)
    {
        if (!preg_match('/^[\w\-\.]+$/', $filename)) {
            abort(422, 'Nom de fichier invalide.');
        }

        $path = public_path('images/uploads/' . $filename);

        if (!file_exists($path)) {
            abort(404, 'Fichier introuvable.');
        }

        unlink($path);

        return back()->with([
            'message' => 'Image supprimée.',
            'type'    => 'success',
        ]);
    }
}
