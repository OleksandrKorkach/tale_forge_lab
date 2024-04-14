<?php

namespace App\Http\Controllers;

use App\Services\PageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    private PageService $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    public function show($bookId, $pageId): Response
    {
        $data = $this->pageService->getPageDetails($bookId, $pageId);
        return Inertia::render('Books/Pages/Show', $data);
    }

    public function storeBlock(Request $request, $bookId, $pageId): RedirectResponse
    {
        $this->pageService->addBlockToPage($request, $bookId, $pageId);
        return Redirect::back();
    }

    public function destroyBlock($blockId): RedirectResponse
    {
        $this->pageService->destroyBlock($blockId);
        return Redirect::back();
    }
}
