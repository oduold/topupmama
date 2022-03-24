<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for($i = 0; $i < 30; $i++) {
            $c = new Comment();
            $c->comment = Str::random(128);
            $c->book_id = rand(1,4);
            $ip = rand(0,255).'.'.rand(0,255).'.'.rand(0,255).'.'.rand(0,255);
            $c->ip = ip2long($ip);
            $c->save();
        }
    }
}
