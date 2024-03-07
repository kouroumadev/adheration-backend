<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class ChangerEmployeur extends Mailable
{
    use Queueable, SerializesModels;

    public $nom;
    public $prenom;
    public $mat;
    public $emp;

    public function __construct($nom,$prenom,$mat,$emp)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->mat = $mat;
        $this->emp = $emp;


    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Changer Employeur',
            from: new Address('admin@cnssgn.com'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.changerEmployeur',
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
