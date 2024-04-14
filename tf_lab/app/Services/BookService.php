<?php

namespace App\Services;

use App\Models\book\Book;
use App\Models\book\Page;
use App\Models\book\PageBlock;
use App\Repositories\BookRepository;
use Illuminate\Http\Request;

class BookService
{
    private BookCommentService $bookCommentService;

    public function __construct(BookCommentService $bookCommentService)
    {
        $this->bookCommentService = $bookCommentService;
    }

    public function getBookDetails($request, $id): array
    {
        $book = $this->getBook($id);
        $comments = $this->bookCommentService->getBookComments($request, $id);
        $genres = $this->getBookGenres($id);
        $tags = $this->getBookTags($id);
        $isFavourite = $book->isFavoritedBy(auth()->user());
        return [
            'book' => $book,
            'comments' => $comments,
            'genres' => $genres,
            'tags' => $tags,
            'isFavourite' => $isFavourite,
        ];
    }

    public function getAllBooks()
    {
        return Book::all();
    }

    public function getBook($id): Book
    {
        return Book::findOrFail($id);
    }

    public function getBookGenres($bookId)
    {
        return Book::find($bookId)->genres;
    }

    public function getBookTags($bookId)
    {
        return Book::find($bookId)->tags;
    }

}
