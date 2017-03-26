<?php

namespace marcocastignoli\authorization;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class AuthorizationSeeder extends Seeder {

    public function run(){

        DB::table('users')->insert([
            'auth' => "0",
            'email' => 'marco',
            'password' => "\$2y\$10\$kx7bWSdCT0bRkTedhg7oQuLsIF8yEt4NozNjOBnzWmLxthec5ChIa",
        ]);
        
        DB::table('authorizations')->insert([
            ["auth"=>0, "object"=>'User',           "field"=>'email',   "method"=>'show',   "entity"=>'*'],
            ["auth"=>0, "object"=>'User',           "field"=>'id',      "method"=>'show',   "entity"=>'*'],
            ["auth"=>0, "object"=>'User',           "field"=>'*',       "method"=>'show',   "entity"=>'my'],
            ["auth"=>0, "object"=>'Authorization',  "field"=>'*',       "method"=>'show',   "entity"=>'my'],
            ["auth"=>0, "object"=>'User',           "field"=>'email',   "method"=>'post',   "entity"=>'my'],
            ["auth"=>0, "object"=>'User',           "field"=>'*',       "method"=>'put',    "entity"=>'*'],
            ["auth"=>0, "object"=>'User',           "field"=>'*',       "method"=>'delete', "entity"=>'*']
        ]);
    }
}
