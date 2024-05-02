<?php

namespace App\Services;

use App\Models\community\Club;
use App\Models\community\Topic;
use App\Models\community\TopicComment;
use App\Models\user\User;
use Illuminate\Support\Facades\Auth;

class CommunityService
{

    public function getAllClubs()
    {
        return Club::orderBy('members', 'desc')->get();
    }

    public function getAllTopics()
    {
        return Topic::orderBy('number_of_replies', 'desc')->get();
    }

    public function getClub($clubId)
    {
        return Club::find($clubId);
    }

    public function getTopic($topicId)
    {
        return Topic::with(['comments' => function ($query) {
            $query->whereNull('comment_id')->with('replies');
        }])->findOrFail($topicId);
    }

    public function storeTopicComment(\Illuminate\Http\Request $request, $topicId): void
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

    public function deleteTopicComment($commentId): void
    {
        $comment = TopicComment::find($commentId);
        $topic = Topic::find($comment->topic_id);
        $topic->decrement('number_of_replies', $comment->replies->count() + 1);
        TopicComment::destroy($commentId);
    }

    public function deleteTopic($topicId): void
    {
        Topic::destroy($topicId);
    }
}
