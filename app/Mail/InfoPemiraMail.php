<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Mime\Email;

class InfoPemiraMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;

    /**
     * Create a new message instance.
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;

        // ✅ Tambahkan header List-Unsubscribe sebagai callback di sini
        $this->withSymfonyMessage(function (Email $message) {
            $message->getHeaders()->addTextHeader(
                'List-Unsubscribe',
                '<mailto:unsubscribe@enyoblos.com>'
            );
        });
    }
    public function build()
    {
        return $this->subject('Informasi Pemira')
                    ->view('emails.info_pemira')
                    ->withSymfonyMessage(function (Email $message) {
                        $message->getHeaders()->addTextHeader(
                            'List-Unsubscribe',
                            '<mailto:unsubscribe@example.com>'
                        );
                    });
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Info Pemira Kahima 2025',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.info_pemira',
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
