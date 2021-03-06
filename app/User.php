<?php

    namespace App;

    use Illuminate\Notifications\Notifiable;
    use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Illuminate\Foundation\Auth\User as Authenticatable;

    class User extends Authenticatable
    {
        use Notifiable;

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'name',
            'email',
            'password',
            'dropbox_token'
        ];

        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
            'password',
            'remember_token',
        ];

        public function BankAccounts()
        {
            return $this->hasMany('App\BankAccount');
        }

        public function PaymentRequests()
        {
            return $this->hasMany('App\PaymentRequest');
        }
        
        public function plannedPayments()
        {
            return $this->hasMany('App\PlannedPayment', 'receiver_id');
        }

        public function contacts()
        {
            return $this->hasMany('App\Contact');
        }

        public function donations()
        {
            return $this->hasMany('App\Donation');
        }

        public function groups()
        {
            return $this->hasMany('App\Group');
        }
    }
