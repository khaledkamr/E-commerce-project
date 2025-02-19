<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class ShopController extends Controller
{
    public function index(Request $request) {
        $column = "";
        $orderBy = "";
        $order = $request->query('order') ? $request->query('order') : -1;
        switch($order) {
            case 1:
                $column = "created_at";
                $orderBy = "DESC";
                break;
            case 2:
                $column = "created_at";
                $orderBy = "ASC";
                break;
            case 3:
                $column = "sale_price";
                $orderBy = "ASC";
                break;
            case 4:
                $column = "sale_price";
                $orderBy = "DESC";
                break;
            default:
                $column = "id";
                $orderBy = "DESC";
        }
        $products = Product::orderBy($column, $orderBy)->paginate(12);
        return view('shop', compact('products', 'order'));
    }

    public function product_details($product_slug) {
        $product = Product::where('slug', $product_slug)->first();
        $related_products = Product::where('slug', '<>', $product_slug)->get()->take(8);
        return view("details", compact("product", "related_products"));
    }
}
