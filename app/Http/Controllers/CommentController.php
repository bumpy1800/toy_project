<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //유효성 검사
        $validatedData = $request->validate([
            'content' => 'required|max:100',
        ]);

        //다시 게시글로 넘어가기위해 post파사드로 게시물 db정보를 가져옴
        $post = Post::find($request->input('post_id'));

        //엘로퀀트ORM이용해서 insert
        $comment = Comment::create([
            'content' => $validatedData['content'],
            'writer' => Auth::user()->name,
            'post_id' => $request->input('post_id'),
            'comment_id' => null,
        ]);
        if(!is_null($comment)){
            return redirect()->route('posts.show',['post' => $post])->with('status', '댓글이 등록되었습니다.');
        }
        else{
            return redirect()->back()->with('status', '댓글 등록에 실패했습니다.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}