<?php

namespace App\Services;

use App\Models\book\Book;
use App\Models\book\Page;
use App\Models\book\PageBlock;
use Illuminate\Http\Request;

class BookService
{
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

    public function getPage($bookId, $pageId): Page
    {
        return Page::where('book_id', $bookId)
            ->where('sequence', $pageId)
            ->firstOrFail();
    }

    public function getPageBlocks($bookId, $pageId = 1) {
        $page = $this->getPage($bookId, $pageId);
        return $page->blocks;
    }

    public function storeBlock(Request $request, $book, $page): void
    {
        $pageId = $this->getPage($book, $page)->id;
        $block = new PageBlock();
        $block->content = $request->input('content');
        $block->page_id = $pageId;
        $block->sequence = 4;
        $block->block_type = 'text';
        $block->created_at = now();
        $block->updated_at = now();
        $block->save();
    }

    public function deleteBlock($block): void
    {
        $blockModel = PageBlock::findOrFail($block);
        $blockModel->delete();
    }

}
