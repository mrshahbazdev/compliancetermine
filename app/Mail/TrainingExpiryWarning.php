<?php

namespace App\Mail;

use App\Models\Training;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TrainingExpiryWarning extends Mailable
{
    use Queueable, SerializesModels;

    public $training;
    public $daysLeft;

    /**
     * Naya instance banayein.
     * @param Training $training
     * @param int $daysLeft
     */
    public function __construct(Training $training, $daysLeft)
    {
        $this->training = $training;
        $this->daysLeft = $daysLeft;
    }

    /**
     * Email ka Subject set karein.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "⚠️ Ablaufwarnung ({$this->daysLeft} Tage): " . $this->training->employee->name,
        );
    }

    /**
     * Email ka content (View) set karein.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.training_expiry', // Ye view humne resources/views/emails/ mein banaya hai
        );
    }

    /**
     * Attachments (Optional)
     */
    public function attachments(): array
    {
        return [];
    }
}