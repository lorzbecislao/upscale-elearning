<?php

namespace App\Services;

use App\Models\College;
use App\Models\Comment;
use App\Models\CommentReply;
use App\Models\Forum;
use App\Models\Like;
use App\Models\View;

class ForumService
{
    public function store(array $forumData, $user = null)
    {
        $user = $user ?: auth()->user();

        $forumData['created_by_id'] = $user->id;

        return Forum::create($forumData);
    }

    public function update($forum, array $forumData)
    {
        $forum->update($forumData);

        return $forum;
    }

    public function close($forum)
    {
        $forum->is_closed = true;
        $forum->save();

        return $forum;
    }

    public function delete($forum)
    {
        $forum->delete();

        return $forum;
    }

    public function getForums($is_closed = false, $limit = null)
    {
        return Forum::where('is_closed', $is_closed)->orderBy('created_at', 'desc')->get()->take($limit)->map(function ($forum) {
            return [
                'id' => $forum->id,
                'title' => $forum->title,
                'question' => $forum->question,
                'course_id' => $forum->course_id,
                'course' => $forum->course?->name,
                'user' => $forum->createdBy,
                'likes' => $forum->likes->count(),
                'comments' => $forum->comments->count(),
                'views' => $forum->views->count(),
                'is_closed' => $forum->is_closed,
                'is_new' => !View::where(['forum_id' => $forum->id, 'user_id' => auth()->user()->id])->exists(),
                'created_at' => $forum->created_at->diffForHumans(),
                'created_by_id' => $forum->created_by_id
            ];
        })->toArray();
    }

    public function like($forum)
    {
        $like = new Like();
        $like->forum_id = $forum->id;
        $like->user_id = auth()->user()->id;
        $like->save();

        return $forum;
    }

    public function comment($forum, $commentData)
    {
        $comment = new Comment();
        $comment->forum_id = $forum->id;
        $comment->user_id = auth()->user()->id;
        $comment->comment = $commentData;
        $comment->save();

        return $forum;
    }

    public function commentReply($comment, $commentReplyData)
    {
        $commentReply = new CommentReply();
        $commentReply->comment_id = $comment->id;
        $commentReply->user_id = auth()->user()->id;
        $commentReply->reply = $commentReplyData;
        $commentReply->save();

        return $comment;
    }

    public function view($forum)
    {
        $existing = View::where(['forum_id' => $forum->id, 'user_id' => auth()->user()->id])->exists();

        if(!$existing) {
            $view = new View();
            $view->forum_id = $forum->id;
            $view->user_id =  auth()->user()->id;
            $view->save();
        }

        return $forum;
    }

    public function getInformation($forum)
    {
        $user = auth()->user();
        $user_likes = $forum->likes->pluck('user_id')->toArray();
        $comments = $forum->comments()->orderBy('created_at', 'desc')->get()->map(function ($comment) {
            $replies = $comment->replies()->orderBy('created_at', 'desc')->get()->map(function ($reply) {
               return [
                   'id' => $reply->id,
                   'user' => $reply->user,
                   'content' => $reply->reply,
                   'created_at' => $reply->created_at->diffForHumans(),
               ];
            });
           return [
               'id' => $comment->id,
               'user' => $comment->user,
               'content' => $comment->comment,
               'created_at' => $comment->created_at->diffForHumans(),
               'replies' => $replies
           ];
        });

        return [
            'id' => $forum->id,
            'title' => $forum->title,
            'question' => $forum->question,
            'course_id' => $forum->course_id,
            'course' => $forum->course?->name,
            'comments' => $comments,
            'user' => $forum->createdBy,
            'is_like' => in_array($user->id, $user_likes),
            'is_closed' => $forum->is_closed,
            'created_at' => $forum->created_at->diffForHumans(),
        ];
    }
}