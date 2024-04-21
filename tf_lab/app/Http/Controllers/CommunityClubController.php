<?php

namespace App\Http\Controllers;

use App\Models\CommunityClub;
use Inertia\Inertia;
use Inertia\Response;

class CommunityClubController extends Controller
{
    public function index(): Response
    {
        $clubs = CommunityClub::orderBy('members', 'desc')->get();
        return Inertia::render('Community/Index', [
            'clubs' => $clubs,
        ]);
    }
}
