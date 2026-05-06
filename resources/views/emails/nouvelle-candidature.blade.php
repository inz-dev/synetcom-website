<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouvelle candidature</title>
    <style>
        body { font-family: Arial, sans-serif; color: #333; margin: 0; padding: 0; background: #f5f7fa; }
        .container { max-width: 600px; margin: 32px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,.08); }
        .header { background: linear-gradient(135deg, #1b449c, #2d5cc8); color: white; padding: 28px 32px; }
        .header h2 { margin: 0 0 6px; font-size: 22px; }
        .header p { margin: 0; opacity: .75; font-size: 14px; }
        .content { padding: 28px 32px; }
        .field { margin-bottom: 20px; }
        .label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: #888; margin-bottom: 4px; }
        .value { font-size: 15px; color: #222; line-height: 1.6; }
        .badge { display: inline-block; padding: 4px 12px; border-radius: 6px; font-size: 12px; font-weight: 700; background: #f15a2d; color: white; margin-right: 8px; }
        .divider { border: none; border-top: 1px solid #eee; margin: 24px 0; }
        .footer { padding: 20px 32px; background: #f8f9fb; text-align: center; font-size: 12px; color: #aaa; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h2>Nouvelle candidature reçue</h2>
        <p>{{ $candidature->opportunite->titre_opportunite }}</p>
    </div>
    <div class="content">
        <div class="field">
            <div class="label">Candidat</div>
            <div class="value">{{ $candidature->prenom_candidat }} {{ $candidature->nom_candidat }}</div>
        </div>
        <div class="field">
            <div class="label">Email</div>
            <div class="value"><a href="mailto:{{ $candidature->email_candidat }}" style="color:#1b449c;">{{ $candidature->email_candidat }}</a></div>
        </div>
        @if($candidature->telephone_candidat)
        <div class="field">
            <div class="label">Téléphone</div>
            <div class="value">{{ $candidature->telephone_candidat }}</div>
        </div>
        @endif
        <hr class="divider">
        <div class="field">
            <div class="label">Poste visé</div>
            <div class="value">
                <span class="badge">{{ $candidature->opportunite->type_contrat }}</span>
                {{ $candidature->opportunite->titre_opportunite }}
            </div>
        </div>
        <div class="field">
            <div class="label">Message de motivation</div>
            <div class="value" style="white-space:pre-wrap; background:#f8f9fb; padding:16px; border-radius:8px; border-left:3px solid #1b449c;">{{ $candidature->message_candidature }}</div>
        </div>
        <div class="field">
            <div class="label">Date de candidature</div>
            <div class="value">{{ $candidature->created_at->format('d/m/Y à H:i') }}</div>
        </div>
        @if($candidature->cv_path)
        <p style="color:#666; font-size:13px; margin-top:16px;">📎 Le CV est joint à cet email.</p>
        @endif
    </div>
    <div class="footer">
        Synetcom — Portail RH &nbsp;·&nbsp; Cet email est généré automatiquement
    </div>
</div>
</body>
</html>
