<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        PaymentMethod::create([
            'name' => 'Barakat R Aziz',
            'account_name' => 'Barakat R Aziz',
            'account_number' => '381072170195',
            'routing_number' => '021200339',
            'iban' => 'EG123456789012345678901234',
            'swift' => 'BOFAUS3N',
            'bank_name' => 'Bank of America',
            'bank_address' => '206 Main St, White Plains,NY10601',
        ]);

        PaymentMethod::create([
            'name' => 'PayPal',
            'account_name' => 'Jane Smith',
            'account_number' => '0987654321',
            'routing_number' => '222000036',
            'iban' => 'EG987654321098765432109876',
            'swift' => 'XYZABC456',
            'bank_name' => 'Paypal Bank',
            'bank_address' => 'New York, USA',
        ]);
    }
}
