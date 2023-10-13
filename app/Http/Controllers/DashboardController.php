<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;

use \App\Models\User;
use \App\Models\Product;
use \App\Models\Category;

class DashboardController extends Controller
{
    /**
     * Used for authenticate user
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Index function is used to show dashboard
     *
     * @return void
     */
    function index()
    {
        $useradmin = count(User::where('is_admin', '=', '2')->get());
        $sales = count(User::where('is_admin', '=', '3')->get());
        $category = count(Category::get());
        $product = count(Product::get());
        $data = compact('useradmin', 'sales', 'category', 'product');
        return view('dashboard')->with($data);
    }
}
