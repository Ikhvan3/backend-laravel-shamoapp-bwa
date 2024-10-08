<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductCategoryController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit');
        $name = $request->input('id');
        $show_product = $request->input('show_product');

        if($id){
            $category = ProductCategory::with(['products'])->find($id);

            if ($category){
                return ResponseFormatter::success(
                    $category,
                    'Data kategori berhasil diambil'
                );

            }else {
                return ResponseFormatter::error(
                    null,
                    'Data kategori tidak ada',
                    404
                );
            }
        }

        $category = ProductCategory::query();

        if($name){
            $category->where('name', 'like', '%' . $name . '%');
        }
        $product = Product::with(['category', 'galleries']);

        if($show_product){
            $category->where('products');
        }

        //mengambil data
        //paginate :untuk mengambil data lebih dari 1
        return ResponseFormatter::success(
            $category->paginate($limit),
            'Data list kategori berhasil diambil'
        );


    }
}
