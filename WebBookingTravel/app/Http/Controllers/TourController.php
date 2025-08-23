<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
class TourController extends Controller
{
    // Form tạo tour mới
    public function create()
    {
        $categories = Category::orderBy('categoryName')->get();
        return view('tours.create', compact('categories'));
    }

    // Lưu tour mới
    public function store(Request $request)
    {
        // Normalize legacy fields to new schema
        $payload = $request->all();
        if ($request->has('name')) {
            $payload['title'] = $request->input('name');
        }
        if ($request->has('price')) {
            $payload['priceAdult'] = $request->input('price');
        }
        if ($request->has('category_id')) {
            $payload['categoryID'] = $request->input('category_id');
        }
        // If a file is provided, save and map to imageURL
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('tours', 'public');
            $payload['imageURL'] = $path; // stored local path
        }

        $validator = Validator::make($payload, [
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'priceAdult' => 'required|numeric|min:0',
            'priceChild' => 'nullable|numeric|min:0',
            'categoryID' => 'nullable|exists:Category,categoryID',
            'startDate' => 'nullable|date',
            'endDate' => 'nullable|date|after_or_equal:startDate',
            // Cho phép nhập URL ảnh cover nhanh
            'imageURL' => 'nullable|url|max:255',
        ]);
        // If imageURL is a local stored path (not http), relax URL rule
        if ($validator->fails() && isset($payload['imageURL']) && !preg_match('/^https?:\/\//i', (string)$payload['imageURL'])) {
            $validator = Validator::make($payload, [
                'title' => 'required|string|max:200',
                'description' => 'nullable|string',
                'quantity' => 'required|integer|min:0',
                'priceAdult' => 'required|numeric|min:0',
                'priceChild' => 'nullable|numeric|min:0',
                'categoryID' => 'nullable|exists:Category,categoryID',
                'startDate' => 'nullable|date',
                'endDate' => 'nullable|date|after_or_equal:startDate',
                'imageURL' => 'nullable|string|max:255',
            ]);
        }
        $validated = $validator->validate();

        $tour = Tour::create($validated);

        if (!empty($validated['imageURL'])) {
            Image::create([
                'tourID' => $tour->tourID,
                'imageURL' => $validated['imageURL'],
                'description' => $tour->title,
            ]);
        }

        return redirect()->route('categories.index')->with('success', 'Tour đã được thêm');
    }

    // Form sửa tour
    public function edit(Tour $tour)
    {
    $categories = Category::orderBy('categoryName')->get();
        return view('tours.edit', compact('tour','categories'));
    }

    // Cập nhật tour
    public function update(Request $request, Tour $tour)
    {
        $payload = $request->all();
        if ($request->has('name')) {
            $payload['title'] = $request->input('name');
        }
        if ($request->has('price')) {
            $payload['priceAdult'] = $request->input('price');
        }
        if ($request->has('category_id')) {
            $payload['categoryID'] = $request->input('category_id');
        }
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('tours', 'public');
            $payload['imageURL'] = $path;
        }

        $validator = Validator::make($payload, [
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'priceAdult' => 'required|numeric|min:0',
            'priceChild' => 'nullable|numeric|min:0',
            'categoryID' => 'nullable|exists:Category,categoryID',
            'startDate' => 'nullable|date',
            'endDate' => 'nullable|date|after_or_equal:startDate',
            'imageURL' => 'nullable|url|max:255',
        ]);
        if ($validator->fails() && isset($payload['imageURL']) && !preg_match('/^https?:\/\//i', (string)$payload['imageURL'])) {
            $validator = Validator::make($payload, [
                'title' => 'required|string|max:200',
                'description' => 'nullable|string',
                'quantity' => 'required|integer|min:0',
                'priceAdult' => 'required|numeric|min:0',
                'priceChild' => 'nullable|numeric|min:0',
                'categoryID' => 'nullable|exists:Category,categoryID',
                'startDate' => 'nullable|date',
                'endDate' => 'nullable|date|after_or_equal:startDate',
                'imageURL' => 'nullable|string|max:255',
            ]);
        }
        $validated = $validator->validate();

        $tour->update($validated);

        if (!empty($validated['imageURL'])) {
            // Thêm ảnh mới vào danh sách ảnh
            Image::create([
                'tourID' => $tour->tourID,
                'imageURL' => $validated['imageURL'],
                'description' => $tour->title,
            ]);
        }

        return redirect()->route('categories.show', $tour->category_id)->with('success', 'Tour đã được cập nhật');
    }

    // Xóa tour
    public function destroy(Tour $tour)
    {
    $category_id = $tour->categoryID;
        // Xoá ảnh trên disk nếu có
    // Lưu ý: ảnh đang lưu URL ngoài, nên không xóa disk. Nếu sau này dùng file local thì xử lý ở đây.
        $tour->delete();
    return redirect()->route('categories.show', $category_id)->with('success','Tour đã được xóa');
    }
    
}
