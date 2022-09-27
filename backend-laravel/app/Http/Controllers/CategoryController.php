<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return CategoryResource::collection(Category::get());
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $category = new Category([
            'name' => $request->get('name'),
        ]);

        $category->save();

        return response()->noContent();
    }

    public function update(Request $request, int $id)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $category = Category::findOrFail($id);

        $category->name = $request->get('name');

        $category->update();

        return response()->noContent();
    }

    public function destroy(int $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->noContent();
    }
}
