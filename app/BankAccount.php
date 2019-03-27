<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class BankAccount extends Model
    {
        protected $fillable = [
            'id',
            'name',
            'account_number',
            'user_id'
        ];

        public function user()
        {
            return $this->belongsTo('App\User');
        }

        public function paymentRequests()
        {
            return $this->hasMany('App\PaymentRequest', 'account_id');
        }

        public function plannedPayments()
        {
            return $this->hasMany('App\PlannedPayment', 'account_id');
        }

        public function donations()
        {
            return $this->hasMany('App\Donation', 'account_id');
        }
    }
