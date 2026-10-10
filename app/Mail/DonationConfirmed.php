<?php

namespace App\Mail;

use App\Models\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DonationConfirmed extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly Donation $donation
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Konfirmasi Donasi #{$this->donation->transaction_code} - {$this->donation->donation_type_label}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.donation-confirmed',
            with: [
                'donation' => $this->donation,
                'profile' => \App\Models\OrganizationProfile::first() ?? \App\Models\OrganizationProfile::getInstance(),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
