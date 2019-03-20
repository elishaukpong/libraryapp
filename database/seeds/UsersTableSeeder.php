<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(App\User::class, 5)->create();

        $users->each(function($user){
            $libraries = factory(App\Models\Library::class, 5)->create([
                'user_id' => $user->id
            ]);

            $libraries->each(function($library){
                $sections = factory(App\Models\LibrarySection::class, rand(2,6))->create([
                    'library_id' => $library->id
                ]);
            });

            // factory(App\Models\LibraryBooks::class, rand(3,7))->create();

            // $sections->each(function($section){

            // });
        });
    }
}
