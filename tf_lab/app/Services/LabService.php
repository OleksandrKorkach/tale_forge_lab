<?php

namespace App\Services;

use App\Models\book\Book;
use App\Models\page\Page;
use App\Models\user\User;
use App\Utils\DateUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LabService
{

    public function getAuthUserBooks(): \Illuminate\Database\Eloquent\Collection|array
    {
        return Book::query()
            ->where('user_id', Auth::id())
            ->get();
    }

    public function storeBook(Request $request): void
    {
        $publicPath = $this->saveImage($request->file('image'));

        $book = Book::create([
            'title' => $request['title'],
            'description' => $request['description'],
            'quote' => $request['quote'],
            'url' => !empty($publicPath) ? $publicPath : null,
            'language' => $request['language'],
            'age_rating' => $request['age_rating'],
            'author_name' => User::find(Auth::id())->name,
            'user_id' => Auth::id(),
        ]);

        $this->syncGenres($book, $request->input('genres', []));

        Page::create([
            'book_id' => $book->id,
            'sequence' => 1,
        ]);
    }

    public function updateBook(Request $request, $bookId): void
    {
        $book = Book::findOrFail($bookId);

        $publicPath = $this->saveImage($request->file('image'));

        $updateData = [
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'quote' => $request->input('quote'),
            'language' => $request->input('language'),
            'age_rating' => $request->input('age_rating'),
            'url' => $publicPath ?? $book->url,
        ];

        $book->update($updateData);
        $this->syncGenres($book, $request->input('genres', []));
    }

    public function deleteBook($bookId): void
    {
        Book::destroy($bookId);
    }

    public function publishBook($bookId): void
    {
        $book = Book::find($bookId);
        $book->is_published = !$book->is_published;
        if ($book->published_at == null) {
            $book->season = DateUtil::getCurrentSeason();
            $book->year = now()->year;
            $book->published_at = now();
        }
        $book->save();
    }

    private function saveImage($image): ?string
    {
        if (!$image) {
            return null;
        }

        $path = $image->store('public/images');
        return str_replace('public/', '/storage/', $path);
    }

    private function syncGenres(Book $book, array $genreIds): void
    {
        $book->genres()->sync($genreIds);
    }


}
