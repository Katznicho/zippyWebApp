<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccountCreation extends Mailable
{
    use Queueable, SerializesModels;

    public string $full_name;
    public string $password;

    public string $role;
    /**
     * Create a new message instance.
     */
    public function __construct(string $full_name, string $password, string $role)
    {
        //
        $this->full_name =  $full_name;
        $this->password =  $password;
        $this->role = $role;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Account Creation',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.user.account',
            with: [
                'name' => $this->full_name,
                "password" => $this->password,
                "role" => $this->role
            ]

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
