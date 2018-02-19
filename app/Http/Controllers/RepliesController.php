<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Reply;
use App\Http\Requests\ReplyRequest;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(ReplyRequest $request, Reply $reply)
    {
        $reply->user_id = Auth::id();
        $reply->topic_id = $request->topic_id;
        $reply->content = $request->content;
        $reply->save();

        return redirect()->to($reply->topic->link())->with('success', '创建成功！');
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('destroy', $reply);
        $reply->delete();

        return redirect()->to($reply->topic->link())->with('success', '删除成功！');
    }
}