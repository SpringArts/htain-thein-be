<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifyAcceptOrRejectMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $status;
    /**
     * Create a new message instance.
     */
    public function __construct(string $status)
    {
        $this->status = $status;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Notify Accept Or Reject Mail',
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

    public function build(): self
    {
        return $this->view('emails.AcceptOrRejectMail')
            ->with([
                'status' => $this->status,
            ]);
    }
}
