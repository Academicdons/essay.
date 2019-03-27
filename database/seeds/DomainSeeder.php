<?php

use Illuminate\Database\Seeder;

class DomainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $domains = [
            ["name"=>"localhost","email"=>"localhost@local.com","tag_line"=>"The ultimate web app","phone_number"=>"0718942538","domain_type"=>0],
            ["name"=>"127.0.0.1:8000","email"=>"localhost@local.com","tag_line"=>"The ultimate web app","phone_number"=>"0718942538","domain_type"=>0],
            ["name"=>"127.0.0.1","email"=>"localhost@local.com","tag_line"=>"The ultimate web app","phone_number"=>"0718942538","domain_type"=>0]
        ];

        foreach ($domains as $domain) {
            \App\Models\FqdnConfiguration::create($domain);
        }
    }
}
