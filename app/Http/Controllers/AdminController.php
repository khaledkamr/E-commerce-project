<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index() {
        return view("admin.index");
    }

    public function brands() {
        $brands = Brand::orderBy("id", "DESC")->paginate(10);
        return view("admin.brands", compact("brands"));
    }

    public function addBrand() {
        return view("admin.brand-add");
    }

    public function brand_store(Request $request) {
        $data = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands,slug',
            'image' => 'mimes:png,jpeg,jpg|image'
        ]);
        $data["image"] = Storage::putFile("brands", $request->image);
        Brand::create($data);
        session()->flash("success", "brand has been added successfully!");
        return redirect(route("admin.brands"));
    }

    public function delete_brand($id) {
        $brand = Brand::findOrFail($id);
        $brand_name = $brand->name;
        Storage::delete($brand->image);
        $brand->delete();
        session()->flash("success", "$brand_name brand has been deleted successfully");
        return redirect(route("admin.brands"));
    }

    public function edit_brand($id) {
        $brand = Brand::findOrFail($id);
        return view("admin.brand-edit")->with("brand", $brand);
    }

    public function update_brand($id, Request $request) {
        $data = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands,slug',
            'image' => 'mimes:png,jpeg,jpg|image'
        ]);
        $brand = Brand::findOrFail($id);
        if($request->has("image")) {
            Storage::delete($brand->image);
            $data["image"] = Storage::putFile("brands", $request->image);
        }
        $brand->update($data);
        session()->flash("success", "brand updated successfully");
        return redirect(route("admin.brands"));
    }

    //-------------------------------------------------------------------

    public function categories() {
        $categories = Category::orderBy("id", "DESC")->paginate(10);
        return view("admin.categories", compact("categories"));
    }

    public function add_category() {
        return view("admin.category-add");
    }

    public function store_category(Request $request) {
        $data = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug',
            'image' => 'mimes:png,jpeg,jpg|image'
        ]);
        $data["image"] = Storage::putFile("categories", $request->image);
        Category::create($data);
        session()->flash("success", "Category has been added successfully!");
        return redirect(route("admin.categories"));
    }

    public function delete_category($id) {
        $category = Category::findOrFail($id);
        $category_name = $category->name;
        Storage::delete($category->image);
        $category->delete();
        session()->flash("success", "$category_name category has been deleted successfully");
        return redirect(route("admin.categories"));
    }

    public function edit_category($id) {
        $category = Category::findOrFail($id);
        return view("admin.category-edit", compact("category"));
    }

    public function update_category($id, Request $request) {
        $data = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug',
            'image' => 'mimes:png,jpeg,jpg|image'
        ]);
        $category = Category::findOrFail($id);
        if($request->has("image")) {
            Storage::delete($category->image);
            $date["image"] = Storage::putFile("categories", $request->image);
        }
        $category->update($data);
        session()->flash("success", "Category updated successfully");
        return redirect(route("admin.categories"));
    }

    //--------------------------------------------------------------------------

    public function products() {
        $products = Product::orderBy("created_at", "DESC")->paginate(10);
        return view("admin.products", compact("products"));
    }

    public function add_product() {
        $categories = Category::select("id", "name")->orderBy("name")->get();
        $brands = Brand::select("id", "name")->orderBy("name")->get();
        return view("admin.product-add", compact("categories", "brands"));
    }

    public function store_product(Request $request) {
        $data = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug',
            'short_description' => 'required',
            'description' => 'required',
            'regular_price' => 'required',
            'sale_price' => 'required',
            'SKU' => 'required',
            'stock_status' => 'required',
            'featured' => 'required',
            'quantity' => 'required|integer',
            'image' => 'required|mimes:png,jpeg,jpg',
            'images.*' => 'image|mimes:png,jpeg,jpg',
            'category_id' => 'required',
            'brand_id' => 'required'
        ]);
        $data["image"] = Storage::putFile("products", $request->image);
        $images = [];
        if($request->hasFile("images")) {
            foreach($request->file("images") as $image) {
                $images[] = Storage::putFile("products", $image);
            }
        }
        $data["images"] = implode(",", $images);
        // dd($data["images"]);
        Product::create($data);
        session()->flash("success", "$request->name has been added successfully!");
        return redirect(route("admin.products"));
    }

    public function edit_product($id) {
        $product = Product::findOrFail($id);
        $categories = Category::select("id", "name")->orderBy("name")->get();
        $brands = Brand::select("id", "name")->orderBy("name")->get();
        return view("admin.product-edit", compact("product", "categories", "brands"));
    }

    public function update_product($id, Request $request) {
        $data = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug',
            'short_description' => 'required',
            'description' => 'required',
            'regular_price' => 'required',
            'sale_price' => 'required',
            'SKU' => 'required',
            'stock_status' => 'required',
            'featured' => 'required',
            'quantity' => 'required|integer',
            'image' => 'mimes:png,jpeg,jpg',
            'images.*' => 'image|mimes:png,jpeg,jpg',
            'category_id' => 'required',
            'brand_id' => 'required'
        ]);
        $product = Product::findOrFail($id);
        if($request->has("image")) {
            Storage::delete($product->image);
            $date["image"] = Storage::putFile("products", $request->image);
        }
        $product->update($data);
        session()->flash("success", "Product updated successfully");
        return redirect(route("admin.products"));
    }
}
