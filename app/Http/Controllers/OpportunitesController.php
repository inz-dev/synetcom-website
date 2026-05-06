<?php

namespace App\Http\Controllers;

use App\Mail\NouvelleCandidate;
use App\Models\Candidature;
use App\Models\Opportunites;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class OpportunitesController extends Controller
{
    // ── PUBLIC ──────────────────────────────────────────────────────────────

    public function index()
    {
        $opportunites = Opportunites::where('est_active', true)
            ->orderByDesc('created_at')
            ->get();

        return Inertia::render('Opportunites/Index', [
            'opportunites' => $opportunites,
        ]);
    }

    public function show(string $id)
    {
        $opportunite = Opportunites::where('id_opportunite', $id)
            ->where('est_active', true)
            ->firstOrFail();

        return Inertia::render('Opportunites/Show', [
            'opportunite' => $opportunite,
        ]);
    }

    public function postuler(Request $request, string $id)
    {
        $opportunite = Opportunites::where('id_opportunite', $id)
            ->where('est_active', true)
            ->firstOrFail();

        $validated = $request->validate([
            'nom_candidat'        => 'required|string|max:100',
            'prenom_candidat'     => 'required|string|max:100',
            'email_candidat'      => 'required|email|max:150',
            'telephone_candidat'  => 'nullable|string|max:20',
            'message_candidature' => 'required|string|min:20|max:3000',
            'cv'                  => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $cvPath = null;
        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('cvs', 'public');
        }

        $candidature = Candidature::create([
            'id_opportunite'      => $opportunite->id_opportunite,
            'nom_candidat'        => $validated['nom_candidat'],
            'prenom_candidat'     => $validated['prenom_candidat'],
            'email_candidat'      => $validated['email_candidat'],
            'telephone_candidat'  => $validated['telephone_candidat'] ?? null,
            'message_candidature' => $validated['message_candidature'],
            'cv_path'             => $cvPath,
        ]);

        $candidature->load('opportunite');

        try {
            $adminEmail = config('mail.from.address', 'admin@synetcom.com');
            Mail::to($adminEmail)->send(new NouvelleCandidate($candidature));
        } catch (\Exception $e) {
            // Mail failure doesn't block the user
        }

        return back()->with('flash', [
            'type'    => 'success',
            'message' => 'Votre candidature a été soumise avec succès !',
        ]);
    }

    // ── ADMIN ────────────────────────────────────────────────────────────────

    public function adminIndex()
    {
        $opportunites = Opportunites::withCount('candidatures')
            ->orderByDesc('created_at')
            ->get();

        $candidatures = Candidature::with('opportunite')
            ->orderByDesc('created_at')
            ->get();

        return Inertia::render('Opportunites/Admin', [
            'opportunites' => $opportunites,
            'candidatures' => $candidatures,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre_opportunite'       => 'required|string|max:255',
            'description_opportunite' => 'required|string',
            'type_contrat'            => 'required|in:CDI,CDD,Stage,Alternance,Freelance',
            'lieu_opportunite'        => 'nullable|string|max:150',
            'date_limite'             => 'nullable|date|after:today',
            'est_active'              => 'boolean',
        ]);

        Opportunites::create($validated);

        return back()->with('flash', ['type' => 'success', 'message' => 'Offre créée avec succès.']);
    }

    public function update(Request $request, string $id)
    {
        $opportunite = Opportunites::where('id_opportunite', $id)->firstOrFail();

        $validated = $request->validate([
            'titre_opportunite'       => 'required|string|max:255',
            'description_opportunite' => 'required|string',
            'type_contrat'            => 'required|in:CDI,CDD,Stage,Alternance,Freelance',
            'lieu_opportunite'        => 'nullable|string|max:150',
            'date_limite'             => 'nullable|date',
            'est_active'              => 'boolean',
        ]);

        $opportunite->update($validated);

        return back()->with('flash', ['type' => 'success', 'message' => 'Offre mise à jour.']);
    }

    public function destroy(string $id)
    {
        $opportunite = Opportunites::where('id_opportunite', $id)->firstOrFail();
        $opportunite->delete();

        return back()->with('flash', ['type' => 'success', 'message' => 'Offre supprimée.']);
    }

    public function updateCandidature(Request $request, string $id)
    {
        $candidature = Candidature::where('id_candidature', $id)->firstOrFail();

        $request->validate([
            'statut' => 'required|in:en_attente,vue,acceptee,refusee',
        ]);

        $candidature->update(['statut' => $request->statut]);

        return back()->with('flash', ['type' => 'success', 'message' => 'Statut mis à jour.']);
    }

    public function viewCv(string $id)
    {
        $candidature = Candidature::where('id_candidature', $id)->firstOrFail();

        if (!$candidature->cv_path || !Storage::disk('public')->exists($candidature->cv_path)) {
            abort(404, 'CV introuvable.');
        }

        $ext = strtolower(pathinfo($candidature->cv_path, PATHINFO_EXTENSION));
        $mime = match($ext) {
            'pdf'  => 'application/pdf',
            'doc'  => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            default => 'application/octet-stream',
        };

        return response()->file(
            Storage::disk('public')->path($candidature->cv_path),
            ['Content-Type' => $mime, 'Content-Disposition' => 'inline']
        );
    }

    public function downloadCv(string $id)
    {
        $candidature = Candidature::where('id_candidature', $id)->firstOrFail();

        if (!$candidature->cv_path || !Storage::disk('public')->exists($candidature->cv_path)) {
            abort(404, 'CV introuvable.');
        }

        $filename = 'CV_' . $candidature->prenom_candidat . '_' . $candidature->nom_candidat
                    . '.' . pathinfo($candidature->cv_path, PATHINFO_EXTENSION);

        return Storage::disk('public')->download($candidature->cv_path, $filename);
    }
}
