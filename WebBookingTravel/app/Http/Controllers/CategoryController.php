<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Hiển thị danh sách category
    public function index()
    {
        $categories = Category::with('tours')->get();
        return view('categories.index', compact('categories'));
    }

    // Form tạo mới category
    public function create()
    {
        return view('categories.create');
    }

    // Lưu category mới
    public function store(Request $request)
    {
        $data = $request->all();
        if ($request->has('name')) {
            $data['categoryName'] = $request->input('name');
        }
        $validated = $request->validate([
            'name' => 'nullable|string|max:100',
            'categoryName' => 'required_without:name|string|max:100',
            'description' => 'nullable|string',
        ]);
        $payload = [
            'categoryName' => $data['categoryName'] ?? $data['name'],
            'description' => $data['description'] ?? null,
        ];
        Category::create($payload);
        return redirect()->route('categories.index')->with('success', 'Category đã được thêm');
    }

    // Form chỉnh sửa category
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    // Cập nhật category
    public function update(Request $request, Category $category)
    {
        $data = $request->all();
        if ($request->has('name')) {
            $data['categoryName'] = $request->input('name');
        }
        $validated = $request->validate([
            'name' => 'nullable|string|max:100',
            'categoryName' => 'required_without:name|string|max:100',
            'description' => 'nullable|string',
        ]);
        $payload = [
            'categoryName' => $data['categoryName'] ?? $data['name'],
            'description' => $data['description'] ?? null,
        ];
        $category->update($payload);
        return redirect()->route('categories.index')->with('success', 'Category đã được cập nhật');
    }

    // Xóa category
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category đã được xóa');
    }

    // Hiển thị các tour của category
    public function show(Category $category)
    {
        $category->load('tours');
        return view('categories.show', compact('category'));
    }
}
