<?php

use Illuminate\Database\Seeder;
use App\Models\Tags;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = factory(App\Models\Tags::class, 5)->create();
        $users = factory(App\User::class, 5)->create();

        $users->each(function($user){
            $libraries = factory(App\Models\Library::class, 5)->create([
                'user_id' => $user->id
            ]);

            $libraries->each(function($library){
                $sections = factory(App\Models\LibrarySection::class, rand(2,6))->create([
                    'library_id' => $library->id
                ]);

                 $sections->each(function($section){
                    $books = factory(App\Models\LibraryBooks::class, rand(2,6))->create([
                        'library_section_id' => $section->id
                    ]);

                    $books->each(function($book){
                        $book->tags()->attach($this->randomTagId());
                    });
                });
            });
        });


    }

    public function randomTagId(){
        $tagId = Tags::all()->random($this->randomNumber())->pluck('id');
        return $tagId;
    }

    public function randomNumber(){
        return rand(2,5);
    }
}
