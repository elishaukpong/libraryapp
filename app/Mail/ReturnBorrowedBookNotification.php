<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReturnBorrowedBookNotification extends Mailable
{
    use Queueable, SerializesModels;
   public  $book, $daysRemaining;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($book, $daysRemaining)
    {
        $this->book = $book;
        $this->daysRemaining = $daysRemaining;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.returnBorrowedBookNotification');
    }
}
