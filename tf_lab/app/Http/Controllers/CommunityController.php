<?php

namespace App\Http\Controllers;

use App\Models\community\Club;
use App\Models\community\Topic;
use App\Models\community\TopicComment;
use App\Models\user\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class CommunityController extends Controller
{
    public function index(): Response
    {
        $clubs = Club::orderBy('members', 'desc')->get();
        $topics = Topic::orderBy('number_of_replies', 'desc')->get();
        return Inertia::render('Community/Index', [
            'clubs' => $clubs,
            'topics' => $topics,
        ]);
    }

    public function clubs(): Response
    {
        $clubs = Club::orderBy('members', 'desc')->get();
        return Inertia::render('Community/Clubs/Index', [
            'clubs' => $clubs,
        ]);
    }

    public function showClub($clubId): Response
    {
        $club = Club::find($clubId);
        return Inertia::render('Community/Clubs/Show', [
            'club' => $club,
        ]);
    }

    public function topics(): Response
    {
        $topics = Topic::all();
        return Inertia::render('Community/Topics/Index', [
            'topics' => $topics,
        ]);
    }

    public function showTopic($topicId): Response
    {
        $topic = Topic::with(['comments' => function ($query) {
            $query->whereNull('comment_id')->with('replies');
        }])->findOrFail($topicId);

        return Inertia::render('Community/Topics/Show', [
            'topic' => $topic,
            'comments' => $topic->comments,
            'userId' => Auth::id(),
        ]);
    }

    public function storeComment(Request $request, $topicId): void
    {
        $comment = new TopicComment([
            'content' => $request['content'],
            'author_name' => User::find(Auth::id())->name,
            'user_id' => auth()->id(),
            'topic_id' => $topicId,
            'comment_id' => $request->comment_id,
        ]);
        $comment->save();
        Topic::query()->find($topicId)->increment('number_of_replies');
    }

    public function deleteComment($commentId): void
    {
        $comment = TopicComment::find($commentId);
        $topic = Topic::find($comment->topic_id);
        $topic->decrement('number_of_replies', $comment->replies->count() + 1);
        TopicComment::destroy($commentId);
    }

    public function testTopic()
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
        Topic::destroy($topicId);
        return Redirect::to('/community');
    }

}
