<?php

    namespace App\Mail;

    use Illuminate\Bus\Queueable;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;
    use Illuminate\Support\Facades\Session;

    class SendPaymentRequestUrl extends Mailable
    {
        use Queueable, SerializesModels;
        public $name, $id;

        /**
         * Create a new message instance.
         *
         * @return void
         */
        public function __construct($name, $id)
        {
            $this->name = $name;
            $this->id = $id;
        }

        /**
         * Build the message.
         *
         * @return $this
         */
        public function build()
        {
            if (Session::get('language') === "nl") {
                return $this->view('email.nl.PaymentRequest');
            } else {
                return $this->view('email.en.PaymentRequest');

            }
        }
    }
