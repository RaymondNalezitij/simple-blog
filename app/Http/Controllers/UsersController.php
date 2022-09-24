<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::all());
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed'
        ]);

        $user = new User([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'user_type' => $request->get('user_type')
        ]);
        $user->save();

        return response()->noContent();
    }

    public function update(Request $request, int $id)
    {
        $user = User::findOrFail($id);

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->user_type = $request->get('user_type');
        $user->update();

        return response()->noContent();
    }

    public function destroy(int $id)
    {
        $user = User::findOrFail($id);

        foreach ($user->articles as $article) {
            foreach ($article->comments as $comment) {
                $comment->delete();
            }
            $article->delete();
        }

        $user->delete();

        return response()->noContent();
    }
}
