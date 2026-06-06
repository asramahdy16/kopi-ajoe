<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = \App\Models\Menu::latest()->paginate(10);
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.menus.create');
    }

    public function store(\App\Http\Requests\StoreMenuRequest $request)
    {
        $data = $request->validated();
        
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('menus', 'public');
        }

        $menu = \App\Models\Menu::create($data);
        
        // Auto-create menu stock
        \App\Models\MenuStock::create([
            'menu_id' => $menu->id,
            'current_stock' => 0,
            'low_stock_threshold' => 10,
        ]);

        return redirect()->route('admin.menus.index')->with('success', 'Menu created successfully.');
    }

    public function edit(\App\Models\Menu $menu)
    {
        return view('admin.menus.edit', compact('menu'));
    }

    public function update(\App\Http\Requests\UpdateMenuRequest $request, \App\Models\Menu $menu)
    {
        $data = $request->validated();
        
        if ($request->hasFile('image')) {
            if ($menu->image_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($menu->image_path);
            }
            $data['image_path'] = $request->file('image')->store('menus', 'public');
        }

        $menu->update($data);

        return redirect()->route('admin.menus.index')->with('success', 'Menu updated successfully.');
    }

    public function destroy(\App\Models\Menu $menu)
    {
        $menu->delete();
        return redirect()->route('admin.menus.index')->with('success', 'Menu deleted successfully.');
    }
}
