<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifyEmailMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $token;
    public $activationUrl;

    public function __construct($email, $token)
    {
        $this->email = $email;
        $this->token = $token;
        $this->activationUrl = url("/activate-account?token={$token}&email={$email}");
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Activa tu cuenta en Street Urban',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.verify-email',
            with: [
                'email' => $this->email,
                'activationUrl' => $this->activationUrl,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
