<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

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
}
