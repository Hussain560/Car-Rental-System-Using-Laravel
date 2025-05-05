<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OfficeInsertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Office data for fresh insertion
        $offices = [
            [
                'OfficeID' => 1,
                'Name' => 'Riyadh Office',
                'Email' => 'riyadh@carrental.com',
                'PhoneNumber' => '+966500000004',
                'Location' => 'Riyadh Office',
                'Address' => 'King Fahd Road',
                'City' => 'Riyadh',
                'PostalCode' => '12345',
                'Status' => 'Active',
                'OpeningTime' => '08:00:00',
                'ClosingTime' => '20:00:00',
                'Description' => 'Car rental services available at this location.',
                'Notes' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'OfficeID' => 2,
                'Name' => 'Dammam Office',
                'Email' => 'dammam@carrental.com',
                'PhoneNumber' => '+966500000005',
                'Location' => 'Dammam Office',
                'Address' => 'Prince Mohammed Bin Fahd Road',
                'City' => 'Dammam',
                'PostalCode' => '32415',
                'Status' => 'Active',
                'OpeningTime' => '08:00:00',
                'ClosingTime' => '20:00:00',
                'Description' => 'Car rental services available at this location.',
                'Notes' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'OfficeID' => 3,
                'Name' => 'Jeddah Office',
                'Email' => 'jeddah@carrental.com',
                'PhoneNumber' => '+966500000006',
                'Location' => 'Jeddah Office',
                'Address' => 'Medina Road',
                'City' => 'Jeddah',
                'PostalCode' => '23442',
                'Status' => 'Active',
                'OpeningTime' => '08:00:00',
                'ClosingTime' => '20:00:00',
                'Description' => 'Car rental services available at this location.',
                'Notes' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'OfficeID' => 4,
                'Name' => 'Hofuf Office',
                'Email' => 'hofuf@carrental.com',
                'PhoneNumber' => '+966135891234',
                'Location' => 'Hofuf Office',
                'Address' => 'King Abdullah Road',
                'City' => 'Hofuf',
                'PostalCode' => '36361',
                'Status' => 'Active',
                'OpeningTime' => '08:00:00',
                'ClosingTime' => '20:00:00',
                'Description' => 'Car rental services available at this location.',
                'Notes' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];
        
        // Insert the data
        DB::table('offices')->insert($offices);
    }
}
