<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contact::updateOrCreate(
            ['language' => 'en'],
            [
                'address' => 'PO Box 16122 Collins Street West Victoria 8007 Australia',
                'phone' => '(+12) 34567 890 123',
                'email' => 'mail@example.com'
            ]
        );
    }
}
