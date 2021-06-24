<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        App\Provider::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('providers')->insert([
            'name' => 'M-Pesa',
            'type' => 'MOBILE',
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('providers')->insert([
            'name' => 'KCB',
            'type' => 'BANK',
            'paybill' => '522522',
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('providers')->insert([
            'name' => 'Commercial Bank of Africa (CBA)',
            'type' => 'BANK',
            'paybill' => '880100',
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('providers')->insert([
            'name' => 'Co-operative Bank',
            'type' => 'BANK',
            'paybill' => '400200',
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('providers')->insert([
            'name' => 'Standard Chartered Bank',
            'type' => 'BANK',
            'paybill' => '329329',
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('providers')->insert([
            'name' => 'Barclays Bank',
            'type' => 'BANK',
            'paybill' => '303030',
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('providers')->insert([
            'name' => 'NIC Bank',
            'type' => 'BANK',
            'paybill' => '488488',
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('providers')->insert([
            'name' => 'Family Bank',
            'type' => 'BANK',
            'paybill' => '222111',
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('providers')->insert([
            'name' => 'CFC Stanbic Bank',
            'type' => 'BANK',
            'paybill' => '600100',
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('providers')->insert([
            'name' => 'Equity Bank',
            'type' => 'BANK',
            'paybill' => '247247',
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('providers')->insert([
            'name' => 'National Bank',
            'type' => 'BANK',
            'paybill' => '547700',
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('providers')->insert([
            'name' => 'Chase Bank',
            'type' => 'BANK',
            'paybill' => '552800',
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('providers')->insert([
            'name' => 'I & M Bank',
            'type' => 'BANK',
            'paybill' => '542542',
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('providers')->insert([
            'name' => 'Diamond Trust Bank (DTB)',
            'type' => 'BANK',
            'paybill' => '516600',
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('providers')->insert([
            'name' => 'Ecobank',
            'type' => 'BANK',
            'paybill' => '700201',
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('providers')->insert([
            'name' => 'Jamii Bora Bank',
            'type' => 'BANK',
            'paybill' => '529901',
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('providers')->insert([
            'name' => 'Imperial Bank',
            'type' => 'BANK',
            'paybill' => '800100',
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('providers')->insert([
            'name' => 'ABC Bank',
            'type' => 'BANK',
            'paybill' => '111777',
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('providers')->insert([
            'name' => 'Credit Bank',
            'type' => 'BANK',
            'paybill' => '972700',
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
        ]);


        DB::table('providers')->insert([
            'name' => 'Consolidated Bank',
            'type' => 'BANK',
            'paybill' => '508400',
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
        ]);


        DB::table('providers')->insert([
            'name' => 'Equitorial Commercial Bank',
            'type' => 'BANK',
            'paybill' => '498100',
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('providers')->insert([
            'name' => 'K-Rep bank',
            'type' => 'BANK',
            'paybill' => '111999',
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
        ]);


        DB::table('providers')->insert([
            'name' => 'Transnational Bank',
            'type' => 'BANK',
            'paybill' => '862862',
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('providers')->insert([
            'name' => 'Post Office Savings Bank',
            'type' => 'BANK',
            'paybill' => '200999',
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
        ]);


        DB::table('providers')->insert([
            'name' => 'Gulf African Bank',
            'type' => 'BANK',
            'paybill' => '985050',
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
        ]);


        DB::table('providers')->insert([
            'name' => 'Housing Finance',
            'type' => 'BANK',
            'paybill' => '100400',
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
        ]);


        DB::table('providers')->insert([
            'name' => 'Bank of Africa (BOA)',
            'type' => 'BANK',
            'paybill' => '972900',
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
        ]);


        DB::table('providers')->insert([
            'name' => 'UBA Bank',
            'type' => 'BANK',
            'paybill' => '559900',
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
        ]);


        DB::table('providers')->insert([
            'name' => 'Guardian Bank',
            'type' => 'BANK',
            'paybill' => '344501',
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('providers')->insert([
            'name' => 'Prime Bank',
            'type' => 'BANK',
            'paybill' => '982800',
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
        ]);


        DB::table('providers')->insert([
            'name' => 'Guaranty Trust Bank',
            'type' => 'BANK',
            'paybill' => '910200',
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
        ]);


        DB::table('providers')->insert([
            'name' => 'KWFT DTM',
            'type' => 'BANK',
            'paybill' => '101200',
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('providers')->insert([
            'name' => 'SMEP DTM',
            'type' => 'BANK',
            'paybill' => '777001',
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('providers')->insert([
            'name' => 'Musoni',
            'type' => 'BANK',
            'paybill' => '514000',
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('providers')->insert([
            'name' => 'Vision Fund Kenya',
            'type' => 'BANK',
            'paybill' => '200555',
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('providers')->insert([
            'name' => 'Rafiki DTM',
            'type' => 'BANK',
            'paybill' => '802200',
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
        ]);

    }
}
