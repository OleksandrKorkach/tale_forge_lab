<?php

namespace App\Services;

use App\Models\book\Book;
use App\Models\page\Page;
use App\Models\page\PageBlock;
use Illuminate\Http\Request;

class PageService
{
    public function getPageDetails(int $bookId, int $pageId): array
    {
        $book = Book::findOrFail($bookId);
        $page = Page::with('blocks')
            ->where('book_id', $bookId)
            ->where('sequence', $pageId)
            ->firstOrFail();

        return [
            'book' => $book,
            'blocks' => $page->blocks,
        ];
    }

    public function addBlockToPage(Request $request, $bookId, $pageId): void
    {
        $pageId = Page::where(['book_id' => $bookId, 'sequence' => $pageId])->firstOrFail()->id;
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
