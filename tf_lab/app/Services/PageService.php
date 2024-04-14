<?php

namespace App\Services;

use App\Models\book\Book;
use App\Models\book\Page;
use App\Models\book\PageBlock;
use Illuminate\Http\Request;

class PageService
{
    public function getPageDetails($bookId, $pageId): array
    {
        $book = Book::findOrFail($bookId);
        $page = Page::with('blocks')->where('book_id', $bookId)->findOrFail($pageId);

        return [
            'book' => $book,
            'blocks' => $page->blocks,
        ];
    }

    public function addBlockToPage(Request $request, $bookId, $pageId): void
    {
        $block = new PageBlock([
            'content' => $request->input('content'),
            'page_id' => $pageId,
            'block_type' => $request->input('type', 'text'),
        ]);
        $block->save();
    }

    public function destroyBlock($blockId): void
    {
        PageBlock::find($blockId)->delete();
    }
}
