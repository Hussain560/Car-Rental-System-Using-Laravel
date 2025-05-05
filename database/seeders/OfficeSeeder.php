<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Office data to be inserted
        $offices = [
            1 => [
                'Name' => 'Riyadh Office',
                'Email' => 'riyadh@carrental.com',
                'Address' => 'King Fahd Road',
                'City' => 'Riyadh',
                'PostalCode' => '12345',
            ],
            2 => [
                'Name' => 'Dammam Office',
                'Email' => 'dammam@carrental.com',
                'Address' => 'Prince Mohammed Bin Fahd Road',
                'City' => 'Dammam',
                'PostalCode' => '32415',
            ],
            3 => [
                'Name' => 'Jeddah Office',
                'Email' => 'jeddah@carrental.com',
                'Address' => 'Medina Road',
                'City' => 'Jeddah',
                'PostalCode' => '23442',
            ],
            4 => [
                'Name' => 'Hofuf Office',
                'Email' => 'hofuf@carrental.com',
                'Address' => 'King Abdullah Road',
                'City' => 'Hofuf',
                'PostalCode' => '36361',
            ],
        ];
        
        // Update existing records with proper data
        foreach ($offices as $id => $data) {
            DB::table('offices')
                ->where('OfficeID', $id)
                ->update([
                    'Name' => $data['Name'],
                    'Email' => $data['Email'],
                    'Address' => $data['Address'],
                    'City' => $data['City'],
                    'PostalCode' => $data['PostalCode'],
                    'Status' => 'Active',
                    'OpeningTime' => '08:00:00',
                    'ClosingTime' => '20:00:00',
                    'Description' => 'Car rental services available at this location.',
                ]);
        }
    }
}
