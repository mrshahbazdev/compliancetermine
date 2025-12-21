<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::all();
        return view('tenant.categories.index', compact('categories'));
    }

    public function store(Request $request) {
        $request->validate(['name' => 'required|string|max:255']);
        Category::create($request->only('name'));
        return redirect()->back()->with('success', 'Kategorie erfolgreich hinzugefügt.');
    }

    public function destroy(Category $category) {
        $category->delete();
        return redirect()->back()->with('success', 'Kategorie gelöscht.');
    }
}