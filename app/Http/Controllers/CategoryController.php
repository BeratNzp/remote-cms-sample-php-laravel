<?php

namespace App\Http\Controllers;

use App\Enums\CategoryType;
use App\Enums\BooleanEnum;
use App\Models\Client\Category;
use Illuminate\Http\Request;
use App\Http\Requests\Client\CategoryUpdateRequest;
use App\Helpers\DatabaseConnection;

class CategoryController extends Controller
{
    public function list()
    {
        try {
            DatabaseConnection::setConnection();
            $categories = Category::all();
        } catch (\Exception $e) {
            $categories = null;
        }
        return view('client.category.list', compact([
            'categories', $categories,
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
        if ($request->can_sub_category_id == 'false')
            $can_sub_category_id = 0;
        elseif ($request->can_sub_category_id == 'true')
            $can_sub_category_id = 1;
        if ($category->update([
            'up_category_id' => $request->up_category_id,
            'type_id' => CategoryType::fromValue(CategoryType::parseDatabase($request->type_id)),
            'title' => $request->title,
            'can_sub_category_id' => BooleanEnum::fromValue(BooleanEnum::parseDatabase($can_sub_category_id)),
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
        $selected_category = Category::find($request->id);
        $selected_up_category = Category::find($selected_category->up_category_id);
        $categories = Category::where('can_sub_category_id', BooleanEnum::fromValue(1))->where('type_id', $request->type_id)->get()->except([$selected_category->id]);

        return response()->json([
            'categories' => $categories,
            'selected_category' => $selected_category,
            'selected_up_category' => $selected_up_category,
        ]);
    }

    public function detail(Request $request)
    {
        DatabaseConnection::setConnection();
        $category = Category::find($request->id);

        $types = CategoryType::asSelectArray();
        $selected_type = $category->type_id;
        return response()->json([
            'category' => $category,
            'types' => $types,
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
