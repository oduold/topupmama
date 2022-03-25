<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Author::create(['name' => 'Jeremy Clarkson']);
        Author::create(['name' => 'Josemaria Escriva']);
        Author::create(['name' => 'J.R.R Tolkien']);
        Author::create(['name' => 'Marc Goodman']);
    }
}
