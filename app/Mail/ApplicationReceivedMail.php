<?php

namespace App\Mail;

use App\Models\Recrutement\Candidature;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class ApplicationReceivedMail extends Mailable
{
    public function __construct(public Candidature $candidature) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre candidature a bien été reçue'
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.application-received'
        );
    }
}
