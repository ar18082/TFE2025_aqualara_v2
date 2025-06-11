<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomMail extends Mailable
{
    use Queueable, SerializesModels;

    public $content; // Contenu personnalisable
    public $subject; // Objet du mail
    public $attachments; // Fichiers à joindre
    /**
     * Create a new message instance.
     */
    public function __construct($content, $subject, $attachments = [])
    {
        $this->content = $content;
        $this->subject = $subject;
        $this->attachments = $attachments;
    }

    public function build()
    {
        $mail = $this->subject($this->subject)
            ->view('emails.modelEmail')
            ->with('content', $this->content);

        foreach ($this->attachments as $attachment) {

        }

        return $mail;
    }


}
