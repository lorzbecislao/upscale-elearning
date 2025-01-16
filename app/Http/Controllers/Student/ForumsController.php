<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Forum;
use App\Services\CourseService;
use App\Services\ForumService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ForumsController extends Controller
{
    public function __construct(
        private CourseService $courseService,
        private ForumService  $forumService)
    {
    }

    public function index(): Response
    {
        return Inertia::render('Student/Forums/Index', [
            'courses' => $this->courseService->getAll(),
            'forums' => $this->forumService->getForums(),
            'closedForums' => $this->forumService->getForums(true),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->forumService->store($request->all(), auth()->user());

        return redirect()->back()->with([
            'success' => [
                'header' => 'Forum created successfully!',
                'message' => '',
            ]
        ]);
    }

    public function show(Forum $forum): Response
    {
        // Count view
        $this->forumService->view($forum);

        return Inertia::render('Student/Forums/Show', [
            'forum' => $this->forumService->getInformation($forum)
        ]);
    }

    public function update(Forum $forum, Request $request): RedirectResponse
    {
        $this->forumService->update($forum, $request->all());

        return redirect()->back()->with([
            'success' => [
                'header' => 'Forum updated successfully!',
                'message' => '',
            ]
        ]);
    }

    public function close(Forum $forum): RedirectResponse
    {
        $this->forumService->close($forum);

        return redirect()->back()->with([
            'success' => [
                'header' => 'Congratulations',
                'message' => 'Closed thread successfully',
            ]
        ]);
    }

    public function like(Forum $forum): RedirectResponse
    {
        $this->forumService->like($forum);

        return redirect()->back()->with([
            'success' => [
                'header' => 'Forum liked successfully!',
                'message' => '',
            ]
        ]);
    }

    public function comment(Forum $forum, Request $request): RedirectResponse
    {
        $input = $request->all();

        $this->forumService->comment($forum, $input['comment']);

        return redirect()->back();
    }

    public function commentReply(Comment $comment, Request $request): RedirectResponse
    {
        $input = $request->all();

        $this->forumService->commentReply($comment, $input['reply']);

        return redirect()->back();
    }

    public function delete(Forum $forum): RedirectResponse
    {
        $this->forumService->delete($forum);

        return redirect()->back()->with([
            'success' => [
                'header' => 'Forum deleted successfully!',
                'message' => '',
            ]
        ]);
    }
}
