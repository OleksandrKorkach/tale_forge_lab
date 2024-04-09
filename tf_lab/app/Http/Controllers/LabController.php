<?php

namespace App\Http\Controllers;

use App\Services\LabService;
use Inertia\Inertia;
use Inertia\Response;

class LabController extends Controller
{
    private LabService $labService;

    public function __construct(LabService $labService)
    {
        $this->labService = $labService;
    }


    public function index(): Response
    {
        $books = $this->labService->getUserBooks();
        return Inertia::render('Lab/Index', [
            'books' => $books,
        ]);
    }
}
