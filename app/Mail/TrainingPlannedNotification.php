<?php

namespace App\Mail;

use App\Models\Training;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TrainingPlannedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $training;

    /**
     * Naya instance banayein aur Training data pass karein.
     */
    public function __construct(Training $training)
    {
        $this->training = $training;
    }

    /**
     * Email ka Subject set karein.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Neue Schulung geplant: ' . $this->training->employee->name,
        );
    }

    /**
     * Email ka Template (View) set karein.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.training_planned', // Hum ye view abhi banayenge
        );
    }

    /**
     * Attachments (Zertifikat agar completed ho toh bhej sakte hain, filhal khali hai).
     */
    public function attachments(): array
    {
        return [];
    }
}