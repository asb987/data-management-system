<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use \App\Models\Category;
use \App\Models\Product;

class CategoryController extends Controller
{
    /**
     * it is used for authentication check
     */
    function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * The index function
     *
     */
    public function index()
    {
        if (Auth::user()->is_admin == 1) {
            $data = Category::withTrashed()->orderBy('id_category', 'desc')->get();
        } else {
            $data = Category::orderBy('id_category', 'desc')->get();
        }

        return view('category.category', compact('data'));
    }

    /**
     * Return category form
     *
     */
    public function categoryform()
    {
        $url = url('createcategory');
        $title = "Create category";
        $data = compact('url', 'title');
        
        return view('category.categoryForm')->with($data);
    }

    /**
     * Used to save Category data
     *
     * @param Request $request
     */
    public function create(Request $request)
    {
        $request->validate([
            'category_name' => 'required|max:255',
            'category_description' => 'required'
        ]);
        $cattegory = new Category();
        $cattegory->category_name = $request['category_name'];
        $cattegory->category_description = $request['category_description'];
        $cattegory->save();

        return redirect('createcategory')->with('success', 'Category created successfully.');
    }

    /**
     * Used to get category data and return view
     *
     * @param [int] $id
     */
    function updateCategory($id)
    {
        $category = Category::find($id);
        if (is_null($category)) {
            return redirect('category');
        } else {
            $title = "Update category";
            $url = url('updatecategory') . '/' . $id;
            $data = compact('category', 'url', 'title');

            return view('category.categoryForm')->with($data);
        }
    }

    /**
     * Used to update category data by id
     *
     * @param [int] $id
     * @param Request $request
     */
    function update($id, Request $request)
    {
        $request->validate([
            'category_name' => 'required|max:255',
            'category_description' => 'required'
        ]);

        $category = Category::find($id);
        $category->category_name = $request['category_name'];
        $category->category_description = $request['category_description'];
        $category->save();

        return redirect('category')->with('success', 'Category updated successfully.');
    }

    /**
     * Used to delete category and product using ajax
     *
     * @param Request $request
     * @return json
     */
    function deleteCategory(Request $request)
    {
        $category = Category::find($request['id']);
        if (!is_null($category)) {
            $category->delete();
            $product = Product::where('id_category', '=', $request['id'])->get();
            if (!is_null($product)) {
                foreach ($product as $prd) {
                    $prd->delete();
                }
            }
        }

        exit(json_encode(['status' => 'ok', 'msg' => 'Category deleted successfully']));
    }

    /**
     * Used to force delete category
     *
     * @param [type] $id
     */
    function forceDelete($id)
    {
        $category = Category::withTrashed()->find($id);
        if (!is_null($category)) {
            $category->forceDelete();
        }

        return redirect('category')->with('success', 'Category deleted successfully.');
    }

    /**
     * Used to restore already deleted category
     *
     * @param [int] $id
     */
    function restore($id)
    {
        $category = Category::withTrashed()->find($id);
        if (!is_null($category)) {
            $category->restore();
        }

        return redirect('category')->with('success', 'Category restored successfully.');
    }

    public function getCategoryDetail(Request $req)
    {
        $data = Category::withTrashed()->find($req['id_category']);
        if (!is_null($data)) {
            exit(json_encode(['status' => 'ok' , 'data' => $data]));
        }

        exit(json_encode(['status' => 'ko']));
    }
}
