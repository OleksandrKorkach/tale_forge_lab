<?php

namespace App\Http\Controllers;

use App\Models\community\Club;
use App\Models\community\Topic;
use App\Models\community\TopicComment;
use App\Models\user\User;
use App\Services\CommunityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class CommunityController extends Controller
{
    private CommunityService $communityService;

    public function __construct(CommunityService $communityService)
    {
        $this->communityService = $communityService;
    }

    public function index(): Response
    {
        $clubs = $this->communityService->getAllClubs();
        $topics = $this->communityService->getAllTopics();
        return Inertia::render('Community/Index', [
            'clubs' => $clubs,
            'topics' => $topics,
        ]);
    }

    public function clubs(): Response
    {
        $clubs = $this->communityService->getAllClubs();
        return Inertia::render('Community/Clubs/Index', [
            'clubs' => $clubs,
        ]);
    }

    public function showClub($clubId): Response
    {
        $club = $this->communityService->getClub($clubId);
        return Inertia::render('Community/Clubs/Show', [
            'club' => $club,
            'members' => $club->users,
        ]);
    }

    public function topics(): Response
    {
        $topics = $this->communityService->getAllTopics();
        return Inertia::render('Community/Topics/Index', [
            'topics' => $topics,
        ]);
    }

    public function showTopic($topicId): Response
    {
        $topic = $this->communityService->getTopic($topicId);

        return Inertia::render('Community/Topics/Show', [
            'topic' => $topic,
            'comments' => $topic->comments,
            'userId' => Auth::id(),
        ]);
    }

    public function storeComment(Request $request, $topicId): void
    {
        $this->communityService->storeTopicComment($request, $topicId);
    }

    public function deleteComment($commentId): void
    {
        $this->communityService->deleteTopicComment($commentId);
    }

    public function testTopic(): void
    {
        $lastTopic = Topic::query()->orderBy('id', 'desc')->first();
        Topic::create([
            'title' => 'title' . ($lastTopic->id + 1),
            'description' => 'description' . ($lastTopic->id + 1),
            'username' => 'username' . ($lastTopic->id + 1),
            'user_id' => Auth::id(),
        ]);
    }

    public function deleteTopic($topicId): RedirectResponse
    {
        $this->communityService->deleteTopic($topicId);
        return Redirect::to('/community');
    }

}
