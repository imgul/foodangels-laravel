<?php

namespace Database\Seeders;

use App\Models\Tax;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaxTableSeeder extends Seeder
{


    public array $taxes = array(
        array('id' => '1','label' => 'Food','rate' => '7.00','status' => '5','created_at' => '2022-09-21 19:57:02','updated_at' => '2022-09-21 19:57:02'),
        array('id' => '2','label' => 'Getränke','rate' => '19.00','status' => '5','created_at' => '2022-09-21 19:57:13','updated_at' => '2022-09-21 19:57:13')
      );




    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (env('DEMO_MODE')) {
            foreach ($this->taxes as $tax) {
                Tax::create([
                    'label'  => $tax['label'],
                    'rate' => $tax['rate'],
                    'status'          => $tax['status'],
                    'created_at'    => $tax['created_at'],
                    'updated_at'    => $tax['updated_at'],
                ]);
            }
        }
    }
}
