<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCompletedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
   // public $user;

    public function __construct(Order $order)
    {
        $this->order = $order;
      //  $this->user  = $user;
    }

    public function build()
    {
        return $this->subject('Your Order Has Been Completed')
            ->view('emails.order_completed');
    }
}
