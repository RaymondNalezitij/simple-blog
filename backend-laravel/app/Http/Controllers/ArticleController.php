<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticleWithCommentsResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->get('categories')) {
            $categories = json_decode($request->get('categories'));

            $articles = Article::latest()
                ->whereIn('category_id', $categories)
                ->with(['user', 'category'])
                ->get();
        } else {
            $articles = Article::latest()->with(['user', 'category'])->get();
        }
        return ArticleResource::collection($articles);
    }

    public function show(int $id)
    {
        $article = Article::findOrFail($id);
        return new ArticleWithCommentsResource($article);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'post' => 'required',
        ]);

        $user = Auth::user();

        $article = new Article([
            'title' => $request->get('title'),
            'post' => $request->get('post'),
            'user_id' => $user->id,
            'category_id' => $request->get('category_id')
        ]);

        $article->save();

        return response()->noContent();
    }

    public function update(Request $request, int $id)
    {
        $article = Article::findOrFail($id);

        $user = Auth::user();

        if ($user->user_type === 'Admin' || $user->id === $article->user->id) {

            $this->validate($request, [
                'title' => 'required',
                'post' => 'required',
            ]);

            $article->title = $request->get('title');
            $article->post = $request->get('post');
            $article->category_id = $request->get('category_id');

            $article->update();

            return response()->noContent();
        }
        return response()->json(['message' => 'Not allowed!'], 404);
    }

    public function destroy(int $id)
    {
        $article = Article::findOrFail($id);

        $user = Auth::user();

        if ($user->user_type === 'Admin' || $user->id === $article->user->id) {

            foreach ($article->comments as $comment) {
                $comment->delete();
            }

            $article->delete();

            return response()->noContent();
        }

        return response()->json(['message' => 'Not allowed!'], 404);
    }
}
