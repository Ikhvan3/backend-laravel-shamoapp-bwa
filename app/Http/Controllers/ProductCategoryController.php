<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCategoryRequest;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = ProductCategory::query();

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
            <a href="' . route('dashboard.category.edit', $item->id) . '"
               style="background-color: rgb(55 65 81); color: white;"
               class="inline-block px-3 py-1 m-1 rounded-md hover:opacity-90">
                Edit
            </a>';
                })
                ->rawColumns(['action'])
                ->make();
        }
        return view('pages.dashboard.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dashboard.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductCategoryRequest $request)
    {
        $data = $request->all();

        ProductCategory::create($data);

        return redirect()->route('dashboard.category.index')->with('success', 'Category has been created');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductCategoryRequest $request, ProductCategory $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $category)
    {
        //
    }
}
