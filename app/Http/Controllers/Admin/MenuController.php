<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\MenuCategory;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('category')->latest()->paginate(10);
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        $categories = MenuCategory::all(); // ✅ Perbaikan di sini
        return view('admin.menus.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:menu_categories,id', // ✅ table menu_categories
            'image' => 'nullable|image|max:2048',
        ]);

        $menu = new Menu([
            'name' => $request->name,
            'price' => $request->price,
            'menu_category_id' => $request->category_id // ✅ kolom yang sesuai
        ]);

        if ($request->hasFile('image')) {
            $menu->image = $request->file('image')->store('menus', 'public');
        }

        $menu->save();

        return redirect()->route('admin.menus.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit(Menu $menu)
    {
        $categories = MenuCategory::all(); // ✅
        return view('admin.menus.form', compact('menu', 'categories'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:menu_categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $menu->name = $request->name;
        $menu->price = $request->price;
        $menu->menu_category_id = $request->category_id;

        if ($request->hasFile('image')) {
            $menu->image = $request->file('image')->store('menus', 'public');
        }

        $menu->save();

        return redirect()->route('admin.menus.index')->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->back()->with('success', 'Menu berhasil dihapus.');
    }
}