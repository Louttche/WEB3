<?php

use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $post = new App\Post([
            'title' => 'Let Go',
            'content' =>'Tell us your secrets']);
        $post->save();

        $post = new App\Post([
            'title' => 'Let Go Again ',
            'content' =>'I solemnly swear I am upto no Good']);
        $post->save();

    }
}
