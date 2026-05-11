<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class AccountCreatedMail extends Mailable
{
    public function __construct(public User $user) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre compte Cmlink a été créé'
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.account-created'
        );
    }
}