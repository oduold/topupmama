<?php

namespace Database\Seeders;

use App\Models\Character;
use Illuminate\Database\Seeder;

class CharacterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $m = new Character();
        $m->name = 'Mary';
        $m->book_id = 3;
        $m->gender_id = 1;
        $m->save();
        
        $m = new Character();
        $m->name = 'Christ';
        $m->book_id = 3;
        $m->gender_id = 2;;
        $m->save();
        
        $m = new Character();
        $m->name = 'Jumbo';
        $m->book_id = 4;
        $m->gender_id = 1;
        $m->save();
        
        $m = new Character();
        $m->name = 'Aragorn';
        $m->book_id = 2;
        $m->gender_id = 2;
        $m->save();
        
        
        $m = new Character();
        $m->name = 'Treebeard';
        $m->book_id = 2;
        $m->gender_id = 3;
        $m->save();
        
        $m = new Character();
        $m->name = 'Bobbi';
        $m->book_id = 1;
        $m->gender_id= 1;
        $m->save();
        
        $m = new Character();
        $m->name = 'Sam';
        $m->book_id = 2;
        $m->gender_id = 2;
        $m->save();
    }
}
