<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use \App\Models\Category;
use \App\Models\Product;

class ProductController extends Controller
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
     * @return void
     */
    public function index()
    {
        $obj = new Product();
        $data = $obj->getData();
        
        if (Auth::user()->is_admin != 1) {
            foreach ($data as $k => $d) {
                if ($d->deleted_at != null) {
                    unset($data[$k]);
                }
            }
        }

        return view('product.product', compact('data'));
    }

    /**
     * Used to view product form
     *
     */
    public function productform()
    {
        $url = url('createproduct');
        $title = "Create product";
        $category = Category::get();

        $data = compact('url', 'title', 'category');

        return view('product.productForm')->with($data);
    }

    // create product data
    /**
     * used to create Product data
     *
     * @param Request $request
     */
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required',
            'category' => 'required',
            'file' => 'required|file|max:2048|mimes:jpeg,jpg,png'
        ]);

        if($request->file){
            $imageName = time().'.'.$request->file('file')->extension();
            $request->file->move(public_path('dist/img'), $imageName);
        }

        $product = new Product();
        $product->product_name = $request['name'];
        $product->product_description = $request['description'];
        $product->product_price = $request['price'];
        $product->id_category = $request['category'];
        $product->product_image = $imageName;
        $product->save();

        return redirect('createproduct')->with('success', 'Product created successfully.');
    }

    /**
     * Used to get product data and show it on Form by id
     *
     * @param [int] $id
     */
    function updateproduct($id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            return redirect('product')->with('fail', 'Product not active.');
        } else {
            $title = "Update product";
            $url = url('updateproduct') . '/' . $id;
            $category = Category::get();
            $data = compact('product', 'url', 'title', 'category');

            return view('product.productForm')->with($data);
        }
    }
    
    /**
     * used to get product detail by id
     *
     * @param Request $req
     * @return json
     */
    function getProductdetail(Request $req)
    {
        // $product = Product::find($req['id']);
        $product = new Product();
        $data = $product->getData($req['id'], $req['id_category']);
        if (!is_null($data)) {
            exit(json_encode(['status' => 'ok' , 'data' => $data[0]]));
        }

        exit(json_encode(['status' => 'ko']));
    }


    /**
     * Used to update product by id
     *
     * @param [int] $id
     * @param Request $request
     */
    function update($id, Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required',
            'category' => 'required',
            'file' => 'required|file|max:2048'
        ]);

        if($request->file){
            $imageName = time().'.'.$request->file('file')->extension();
            $request->file->move(public_path('dist/img'), $imageName);
        }

        $product = Product::find($id);
        $product->product_name = $request['name'];
        $product->product_description = $request['description'];
        $product->product_price = $request['price'];
        $product->product_image = $imageName;
        $product->id_category = $request['category'];
        $product->save();

        return redirect('product')->with('success', 'Product updated successfully.');
    }

    /**
     * used to soft delete product
     *
     * @param [int] $id
     * @return void
     */
    // function deleteproduct($id)
    // {
    //     $product = Product::find($id);
    //     if (!is_null($product)) {
    //         $product->delete();
    //     }

    //     return redirect('product')->with('success', 'Product soft deleted successfully.');
    // }
    function deleteproduct(Request $req)
    {
        $product = Product::find($req['id']);
        if (!is_null($product)) {
            $product->delete();
        }
        
        exit(json_encode(['status' => 'ok', 'msg' => 'Product deleted successfully']));
        // return redirect('product')->with('success', 'Product soft deleted successfully.');
    }

    /**
     * Used for force delete product
     *
     * @param [int] $id
     */
    function forceDelete($id)
    {
        $product = Product::withTrashed()->find($id);
        if (!is_null($product)) {
            $product->forceDelete();
        }

        return redirect('product')->with('success', 'Product deleted successfully.');
    }

    /**
     * Used to restore deleted product data
     *
     * @param [int] $id
     */
    function restore($id)
    {
        $product = Product::withTrashed()->find($id);
        if (!is_null($product)) {
            $product->restore();
        }
        
        return redirect('product')->with('success', 'Product restored successfully.');
    }
}
