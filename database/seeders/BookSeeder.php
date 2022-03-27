<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $q1 = Author::query();
        $q2 = Author::query();
        $q3 = Author::query();
        $q4 = Author::query();
        $j = $q1->where('name', 'like', 'Jeremy%')->first();     
        $jr= $q2->where('name', 'like', '%Tolkien%')->first();
        $jm= $q3->where('name', 'like', 'Josemaria%')->first();
        $mg= $q4->where('name', 'like', '%Goodman%')->first();
        
        $b1 = new Book();
        $b1->title = 'Future Crimes';
        $b1->release_date = '2015-01-01';
        $b1->save();
        $a1 = Author::find($mg->id);
        $a1->books()->attach($b1->id);
        
        
        $b2 = new Book();
        $b2->title = 'Lord Of the Rings, The Two Towers';
        $b2->release_date = '1966-01-01';
        $b2->save();
        $a2 = Author::find($jr->id);
        $a2->books()->attach($b2->id);
        
        
        $b3 = new Book();
        $b3->title = 'Furrow';
        $b2->release_date = '1921-01-01';
        $b3->save();
        $a3 = Author::find($jm->id);        
        $a3->books()->attach($b3->id);
        
        
        $b4 = new Book();
        $b4->title = 'The World According to Clarkson';
        $b4->release_date = '2004-07-01';
        $b4->save();
        $a4 = Author::find($j->id);
        $a4->books()->attach($b4->id);        
    }
}
