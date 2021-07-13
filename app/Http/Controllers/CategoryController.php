<?php

namespace App\Http\Controllers;

use App\Enums\CategoryType;
use App\Models\Client\Category;
use Illuminate\Http\Request;
use App\Http\Requests\Client\CategoryUpdateRequest;
use App\Helpers\DatabaseConnection;

class CategoryController extends Controller
{
    public function list()
    {
        DatabaseConnection::setConnection();
        $categories = Category::all();
        return view('client.category.list', compact([
            'categories' , $categories,
        ]));
    }

    public function create()
    {
        DatabaseConnection::setConnection();
        $category = Category::create([
            'title' => 'Yeni Kategori',
        ]);
        return $category->id;
    }

    public function update(CategoryUpdateRequest $request)
    {
        DatabaseConnection::setConnection();
        $category = Category::find($request->id);
        if ($category->update([
            'up_category_id' => $request->up_category_id,
            'type_id' => CategoryType::fromValue(CategoryType::parseDatabase($request->type_id)),
            'title' => $request->title,
        ])) {
            $messages = [
                'status' => 'success',
                'title' => 'Kaydedildi',
                'message' => 'Yönlendiriliyorsunuz.',
            ];
        } else {
            $messages = [
                'status' => 'warning',
                'title' => 'Kaydedilemedi',
                'message' => 'Yönlendiriliyorsunuz.',
            ];
        }
        return response()->json(['messages' => $messages]);
    }

    public function categories_of_type(Request $request)
    {
        DatabaseConnection::setConnection();
        $category = Category::find($request->id);
        $categories = Category::where('type_id', $request->type_id)->get()->except([$category->id]);
        return $categories;
    }

    public function detail(Request $request)
    {
        DatabaseConnection::setConnection();
        $categories = Category::all();
        $category = Category::find($request->id);
        $categories = $categories->except([$category->id]);
        $types = CategoryType::asSelectArray();
        $selected_up_category = Category::find($category->up_category_id);
        $selected_type = $category->type_id;
        return response()->json([
            'categories' => $categories,
            'category' => $category,
            'types' => $types,
            'selected_up_category' => $selected_up_category,
            'selected_type' => $selected_type,
        ]);
    }

    public function delete(Request $request)
    {
        DatabaseConnection::setConnection();
        $category = Category::find($request->id);
        if ($category) {
            if ($category->title === "Yeni Kategori") {
                if ($category->forceDelete()) {
                    $messages = [
                        'status' => 'success',
                        'title' => 'Silindi',
                        'message' => 'Yönlendiriliyorsunuz.',
                    ];
                }
            } else if ($category->delete()) {
                $messages = [
                    'status' => 'success',
                    'title' => 'Silindi',
                    'message' => 'Yönlendiriliyorsunuz.',
                ];
            } else {
                $messages = [
                    'status' => 'warning',
                    'title' => 'Silinemedi',
                    'message' => 'Yönlendiriliyorsunuz.',
                ];
            }
        } else {
            $messages = [
                'status' => 'warning',
                'title' => 'Silinemedi',
                'message' => 'Kategori bulunamadı.',
            ];
        }
        return response()->json([
            'messages' => $messages,
        ]);
    }
}
