<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index()
    {
        return CommentResource::collection(Comment::get());
    }

    public function show(int $id)
    {
        $comment = Comment::findOrFail($id);
        return new CommentResource($comment);
    }

    public function create(Request $request, int $article_id)
    {
        if (!Article::find($article_id)) {

            return response()->json([
                'message' => 'Invalid post!',
                'errors' => [
                    'message' => 'Invalid post!'
                ]
            ], 404);
        }

        $this->validate($request, [
            'user_name' => 'required',
            'comment' => 'required',
        ]);

        $comment = new Comment([
            'article_id' => $article_id,
            'user_name' => $request->get('user_name'),
            'comment' => $request->get('comment')
        ]);

        $comment->save();

        return response()->noContent();
    }

    public function update(Request $request, int $id)
    {
        $this->validate($request, [
            'user_name' => 'required',
            'comment' => 'required',
        ]);

        $comment = Comment::findOrFail($id);

        $comment->user_name = $request->get('user_name');
        $comment->comment = $request->get('comment');

        $comment->update();

        return response()->noContent();
    }

    public function destroy(int $id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return response()->noContent();
    }
}
