<?php

namespace App\Mail;

use App\Models\Candidature;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NouvelleCandidate extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Candidature $candidature) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouvelle candidature — ' . $this->candidature->opportunite->titre_opportunite,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.nouvelle-candidature',
        );
    }

    public function attachments(): array
    {
        if ($this->candidature->cv_path) {
            return [
                Attachment::fromPath(storage_path('app/public/' . $this->candidature->cv_path))
                    ->as('CV_' . $this->candidature->nom_candidat . '_' . $this->candidature->prenom_candidat . '.pdf'),
            ];
        }
        return [];
    }
}
