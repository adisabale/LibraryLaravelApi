<?php

namespace Database\Seeders;

use App\Models\{User,Category,Book,BookDetail};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         User::create([
            'name'     => Str::random(10),
            'email'    => 'test@gmail.com',
            'password' => Hash::make('12345678')
        ]);
         $cat = Category::create([
            'name'        => 'Computer Science',
            'description' => 'Computer Programming,Data Structure,etc'
        ]);
         $book = Book::create([
            'category_id'  => $cat->id,
            'uuid'         => Str::random(10),
            'name'         => 'PHP',
            'releaseDate'  => '2022-03-01',
            'authorName'   => Str::random(10),
            'retailsPrice' => 500,
            'imageName'    => 'Top-View-Book-PSD-Mockup-1-327x400.jpg',
        ]);
         BookDetail::create([
            'book_id'     => $book->id,
            'description' => Str::random(20),
            'pages'       => '416',
            'publisher'   => Str::random(10),
        ]);
         $book = Book::create([
            'category_id'  => $cat->id,
            'uuid'         => Str::random(10),
            'name'         => 'Java',
            'releaseDate'  => '2022-05-01',
            'authorName'   => Str::random(10),
            'retailsPrice' => 500,
            'imageName'    => 'psd-book-template.jpg',
        ]);
         BookDetail::create([
            'book_id'     => $book->id,
            'description' => Str::random(20),
            'pages'       => '416',
            'publisher'   => Str::random(10),
        ]);
         $cat = Category::create([
            'name'        => 'Social Science',
            'description' => 'History of Culture'
        ]);
         $book = Book::create([
            'category_id'  => $cat->id,
            'uuid'         => Str::random(10),
            'name'         => 'C#',
            'releaseDate'  => '2022-03-01',
            'authorName'   => Str::random(10),
            'retailsPrice' => 900,
            'imageName'    => 'ea932bb98415afec4e45913f5628a54a.jpg',
        ]);
         BookDetail::create([
            'book_id'     => $book->id,
            'description' => Str::random(20),
            'pages'       => '716',
            'publisher'   => Str::random(10),
        ]);
    }
}
