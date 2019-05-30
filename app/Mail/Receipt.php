<?php

namespace App\Mail;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Receipt extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    const phone_contact = 'P: +965 96061886';
    const email_contact = 'E: support@yallabit.com';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Receipt #' . $this->order->payment->track_id)
            ->markdown('emails.receipt')
            ->with([
                'customer_name'	    => $this->order->user->name,
                'phone_contact'	    => self::phone_contact,
                'receipt_no'		=> $this->order->payment->track_id,
                'email_contact'	    => self::email_contact,
                'orderItems'		=> $this->order->order_items()->get(),
                'total'             => $this->order->getDueAmount(),
            ]);
    }
}
