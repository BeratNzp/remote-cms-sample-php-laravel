<?php

namespace App\Http\Controllers\Client;

use App\Models\Client\Product;
use App\Http\Requests\Client\ProductUpdateRequest;
use App\Models\Client\Category;
use Illuminate\Http\Request;
use App\Helpers\DatabaseConnection;

class ProductController extends Controller
{
    public function list(Request $request)
    {
        try {
            DatabaseConnection::setConnection();
            Product::where('title', "Yeni Ürün")->forceDelete();
            if ($request->id > 0) {
                $products = Product::where('up_product_id', $request->id)->get();
                $up_product = Product::find($request->id);
            } else {
                $products = Category::where('main_category', BooleanEnum::fromValue(1))->get();
                $up_product = null;
            }
        } catch (\Exception $e) {
            $categories = null;
            $up_category = null;
        }
        return view('client.product.list', compact([
            'products', $products,
            'up_product', $up_product,
        ]));
    }

    public function create(Request $request)
    {
        DatabaseConnection::setConnection();
        if ($request->up_product_id) {
            $up_product_id = Category::find($request->up_product_id)->id;
        } else {
            $up_product_id = null;
        }
        $product = Product::create([
            'up_product_id' => $up_product_id,
            'title' => 'Yeni Ürün',
        ]);
        return $product->id;
    }

    public function update(ProductUpdateRequest $request)
    {
        /*
        DatabaseConnection::setConnection();
        $product = Product::find($request->id);


        if ($request->can_sub_product == 'false') {
            $sub_products = Product::where('up_product_id', $product->id)->get();
            $messages = [
                'status' => 'warning',
                'title' => 'Kaydedilemedi',
                'message' => 'Mevcut varyantlar bulundu.',
            ];
            if (count($sub_products) > 0) {
                return response()->json(['messages' => $messages, 'sub_products' => $sub_products]);
            }
            $can_sub_product = 0;
        } elseif
        ($request->can_sub_product == 'true')
            $can_sub_product = 1;


        if ($request->main_category == 'false') {
            $main_category = 0;
            $up_category_id = $request->up_category_id;
        } elseif ($request->main_category == 'true') {
            $main_category = 1;
            $up_category_id = null;
        }

        $category->update([
            'up_category_id' => $up_category_id,
            'type_id' => CategoryType::fromValue(CategoryType::parseDatabase($request->type_id)),
            'title' => $request->title,
            'can_sub_category' => BooleanEnum::fromValue(BooleanEnum::parseDatabase($can_sub_category)),
            'main_category' => BooleanEnum::fromValue(BooleanEnum::parseDatabase($main_category)),
        ]);

        if ($category) {
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
        */
    }

    public function categories_of_type(Request $request)
    {
        DatabaseConnection::setConnection();
        if(isset($request->id)) {
            $selected_category = Category::find($request->id);
            $selected_up_category = Category::find($selected_category->up_category_id);
            $categories = Category::where('can_sub_category', BooleanEnum::fromValue(1))->where('type_id', $request->type_id)->get()->except([$selected_category->id]);
            return response()->json([
                'categories' => $categories,
                'selected_category' => $selected_category,
                'selected_up_category' => $selected_up_category,
            ]);
        }else{
            $categories = Category::get();
            return response()->json([
                'categories' => $categories,
            ]);
        }
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
