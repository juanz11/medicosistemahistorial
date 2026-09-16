<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Comisiones extends Mailable
{
    use Queueable, SerializesModels;

    public $total;
    public $total_final;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($total, $total_final)
    {
        $this->total = $total;
        $this->total_final = $total_final;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Comisiones por cobertura')->markdown('emails.users.comisiones',[
            'total' => $this->total,
            'total_final' => $this->total_final,
        ]);
    }
}