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
    public function list(Request $request)
    {
        try {
            DatabaseConnection::setConnection();
            Category::where('type_id', null)->forceDelete();
            if ($request->id > 0) {
                $categories = Category::where('up_category_id', $request->id)->get();
                $up_category = Category::find($request->id);
                if ($up_category->up_category_id == null)
                    $up_category = null;
                else
                    $up_category = Category::find($up_category->up_category_id);
            } else {
                $categories = Category::where('main_category', BooleanEnum::fromValue(1))->get();
                $up_category = null;
            }
        } catch (\Exception $e) {
            $categories = null;
            $up_category = null;
        }
        return view('client.category.list', compact([
            'categories', $categories,
            'up_category', $up_category,
        ]));
    }

    public function create(Request $request)
    {
        DatabaseConnection::setConnection();
        if($request->up_category_id) {
            $up_category_id = Category::find($request->up_category_id)->up_category_id;
        }else{
            $up_category_id = null;
        }
        $category = Category::create([
            'up_category_id' => $up_category_id,
            'title' => 'Yeni Kategori',
        ]);
        return $category->id;
    }

    public function update(CategoryUpdateRequest $request)
    {
        DatabaseConnection::setConnection();
        $category = Category::find($request->id);


        if ($request->can_sub_category == 'false') {
            $sub_categories = Category::where('up_category_id', $category->id)->get();
            $messages = [
                'status' => 'warning',
                'title' => 'Kaydedilemedi',
                'message' => 'Mevcut alt kategoriler bulundu.',
            ];
            if (count($sub_categories) > 0) {
                return response()->json(['messages' => $messages, 'sub_categories' => $sub_categories]);
            }
            $can_sub_category = 0;
        } elseif
        ($request->can_sub_category == 'true')
            $can_sub_category = 1;


        if ($request->main_category == 'false') {
            $main_category = 0;
            $up_category_id = $request->up_category_id;
        } elseif ($request->main_category == 'true') {
            $main_category = 1;
            $up_category_id = null;
        }


        if ($category->update([
            'up_category_id' => $up_category_id,
            'type_id' => CategoryType::fromValue(CategoryType::parseDatabase($request->type_id)),
            'title' => $request->title,
            'can_sub_category' => BooleanEnum::fromValue(BooleanEnum::parseDatabase($can_sub_category)),
            'main_category' => BooleanEnum::fromValue(BooleanEnum::parseDatabase($main_category)),
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
        $categories = Category::where('can_sub_category', BooleanEnum::fromValue(1))->where('type_id', $request->type_id)->get()->except([$selected_category->id]);

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
        $sub_categories = Category::where('up_category_id', $category->id)->get();
        if (count($sub_categories) > 0) {
            $messages = [
                'status' => 'warning',
                'title' => 'Silinemedi',
                'message' => 'Alt kategoriler bulundu. Önce alt kategorileri silmeniz gerekmektedir.',
            ];
        } else {
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
        }
        return response()->json([
            'messages' => $messages,
        ]);
    }
}
