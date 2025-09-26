<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
  protected $fillable = [
    'name', 'account_name', 'iban', 'swift', 'account_number'
];

public function enrollments()
{
    return $this->hasMany(Enrollment::class, 'payment_method', 'name');
}

}
