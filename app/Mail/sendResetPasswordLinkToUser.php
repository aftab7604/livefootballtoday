<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendResetPasswordLinkToUser extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    
    public $email_data = null;
    public function __construct($email_data)
    {
        $this->email_data = $email_data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data['data'] = $this->email_data;
        
        return $this
        ->from("support@livefootballtoday.co.uk")
        // ->to("aftab7604@gmail.com")
        ->subject("LiveFootballToday- Password Reset")
        ->markdown('PublicArea.mail.send-reset-password-link',$data);
        
    }
}
