<?php

namespace App\Http\Controllers\Admin;

use App\Models\MenuCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuCategoryController extends Controller
{
    public function index()
    {
        $categories = MenuCategory::all();
        return view('admin.menu-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.menu-categories.form');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        MenuCategory::create($request->all());
        return redirect()->route('admin.menu-categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(MenuCategory $menuCategory)
    {
        return view('admin.menu-categories.form', compact('menuCategory'));
    }

    public function update(Request $request, MenuCategory $menuCategory)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $menuCategory->update($request->all());
        return redirect()->route('admin.menu-categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(MenuCategory $menuCategory)
    {
        $menuCategory->delete();
        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}
