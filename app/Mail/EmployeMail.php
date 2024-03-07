<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class EmployeMail extends Mailable
{
    use Queueable, SerializesModels;
    public $n_immatriculation;
    public $pass;
    public $raison_sociale;
    public $nom;
    public $prenom;

    public function __construct($n_immatriculation,$pass,$raison_sociale,$nom,$prenom)
    {
        $this->n_immatriculation = $n_immatriculation;
        $this->pass = $pass;
        $this->raison_sociale = $raison_sociale;
        $this->nom = $nom;
        $this->prenom = $prenom;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Login Info',
            from: new Address('admin@cnssgn.com'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.employeMail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
