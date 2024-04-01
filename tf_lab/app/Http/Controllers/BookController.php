<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookPageBlock;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class BookController extends Controller
{
    public function index(): Response
    {
        $books = Book::all();
        return Inertia::render('Books/Index', [
            'books' => $books,
        ]);
    }

    public function show($id): Response
    {
        $book = Book::findOrFail($id);
        return Inertia::render('Books/Show', [
            'book' => $book,
        ]);
    }

    public function showPage($book, $page): Response
    {
        $book = Book::query()->findOrFail($book);
        $page = $book->pages->where('sequence', $page)->first();
        $blocks = $page->blocks;
        return Inertia::render('Books/ShowPage', [
            'book' => $book,
            'blocks' => $blocks,
        ]);
    }

    public function addBlockToPage(Request $request, $book, $page): RedirectResponse
    {
        $bookModel = Book::query()->findOrFail($book);
        $pageModel = $bookModel->pages->where('sequence', $page)->firstOrFail();

        $block = new BookPageBlock();
        $block->content = $request->input('content');
        $block->book_page_id = $pageModel->id;
        $block->sequence = 4;
        $block->block_type = 'text';
        $block->created_at = now();
        $block->updated_at = now();

        $block->save();

        return Redirect::back();
    }

    public function destroyPageBlock($block): RedirectResponse
    {
        $blockModel = BookPageBlock::findOrFail($block);
        $blockModel->delete();

        return Redirect::back();
    }
}
