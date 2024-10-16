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
            $limit = $request->input('limit', 6);
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
        } catch (\Exception $e) {
            return ResponseFormatter::error(
                null,
                'Terjadi kesalahan: ' . $e->getMessage(),
                500
            );
        }
        // //memasukan query
        // $id = $request->input('id');
        // $limit = $request->input('limit', 6);
        // $name = $request->input('id');
        // $description = $request->input('description');
        // $tags = $request->input('tags');
        // $categories = $request->input('categories');

        // $price_from = $request->input('price_from');
        // $price_to = $request->input('price_to');

        // if ($id) {
        //     $product = Product::with(['category', 'galleries'])->find($id);

        //     if ($product) {
        //         return ResponseFormatter::success(
        //             $product,
        //             'Data product berhasil diambil'
        //         );
        //     } else {
        //         return ResponseFormatter::error(
        //             null,
        //             'Data product tidak ada',
        //             404
        //         );
        //     }
        // }

        //filter
        $product = Product::with(['category', 'galleries']);

        if ($name) {
            $product->where('name', 'like', '%' . $name . '%');
        }

        if ($description) {
            $product->where('description', 'like', '%' . $description . '%');
        }

        if ($tags) {
            $product->where('tags', 'like', '%' . $tags . '%');
        }

        if ($price_from) {
            $product->where('price', '>=', $price_from);
        }

        if ($price_to) {
            $product->where('price', '<=', $price_to);
        }

        if ($categories) {
            $product->where('categories', $categories);
        }

        //mengambil data
        //paginate :untuk mengambil data lebih dari 1
        return ResponseFormatter::success(
            $product->paginate($limit),
            'Data product berhasil diambil'
        );
    }
}
