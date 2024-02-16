<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserSubscribeUnsubscribe extends Mailable
{
    use Queueable, SerializesModels;

    public string $token;

    public string $email;

    public string $rubric_ids;

    public string $action;

    /**
     * Create a new message instance.
     */
    public function __construct($subject, $token, $email, $rubric_ids, $action)
    {
        $this->subject = $subject;
        $this->token = $token;
        $this->email = $email->value;
        $this->rubric_ids = implode(',', $rubric_ids);
        $this->action = $action;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.email',
            with: [
                'token' => $this->token,
                'email' => $this->email,
                'rubric_ids' => $this->rubric_ids,
                'action' => $this->action,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
