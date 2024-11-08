<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function all(Request $request)
    {
        try {
            $id = $request->input('id');
            $limit = $request->input('limit', 100);
            $name = $request->input('id');
            $description = $request->input('description');
            $tags = $request->input('tags');
            $categories = $request->input('categories');
            $price_from = $request->input('price_from');
            $price_to = $request->input('price_to');

            if ($id) {
                $product = Product::with(['category', 'galleries'])->find($id);

                if ($product) {
                    return ResponseFormatter::success(
                        $product,
                        'Data product berhasil diambil'
                    );
                } else {
                    return ResponseFormatter::error(
                        null,
                        'Data product tidak ada',
                        404
                    );
                }
            }

            $query = Product::with(['category', 'galleries']);

            if ($name) {
                $query->where('name', 'like', '%' . $name . '%');
            }

            if ($description) {
                $query->where('description', 'like', '%' . $description . '%');
            }

            if ($tags) {
                $query->where('tags', 'like', '%' . $tags . '%');
            }

            if ($price_from) {
                $query->where('price', '>=', $price_from);
            }

            if ($price_to) {
                $query->where('price', '<=', $price_to);
            }

            if ($categories) {
                $query->where('category_id', $categories);
            }

            $products = $query->paginate($limit);

            return ResponseFormatter::success(
                $products,
                'Data product berhasil diambil'
            );
        } catch (\Exception $e) {
            return ResponseFormatter::error(
                null,
                'Terjadi kesalahan: ' . $e->getMessage(),
                500
            );
        }
    }
}
