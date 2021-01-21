<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Product;
use App\Collection;
use App\Student;
use App\ClassRoom;
use App\StudentClassRoom;

use Exception;

class ProductController extends Controller
{
    public function index(){
        $products = Product::where('is_deleted', false)->with('collection')->orderBy('name')->get();
        foreach($products as $index => $product){
            $products[$index]->parents = "-";
            if($product->collection) {
                $parents = $product->collection->parents();
                $name = ($parents!='')?$parents . "->" . $product->collection->name : $product->collection->name;
                $products[$index]->parents = $name;
            }
        }
        return view('products.index',[
            'products' => $products,
            'msg_success' => request()->session()->get('msg_success'),
            'msg_error' => request()->session()->get('msg_error')
        ]);
    }

    public function create(Request $request)
    {
        $collections = Collection::where('is_deleted', false)->orderBy('name')->get();
        foreach($collections as $index => $collection){
            $collections[$index]->parents = $collection->parents();
            $collections[$index]->name = ($collections[$index]->parents!='')?$collections[$index]->parents . "->" . $collections[$index]->name : $collections[$index]->name;
        }
        $product = new Product;
        if($request->getMethod()=='GET'){
            return view('products.create', [
                "collections"=>$collections,
                "product"=>$product
            ]);
        }

        $productCollection = new Collection;
        $productCollection->name = $request->input('name', '');
        $productCollection->parent_id = (int)$request->input('collections_id', 0);
        $productCollection->save();

        $product->name = $request->input('name', '');
        $product->collections_id = $productCollection->id;
        $product->price = (int)$request->input('price', 0);
        $product->save();

        $request->session()->flash("msg_success", "محصول با موفقیت افزوده شد.");
        return redirect()->route('products');
    }

    public function edit(Request $request, $id)
    {
        $collections = Collection::where('is_deleted', false)->orderBy('name')->get();
        foreach($collections as $index => $collection){
            $collections[$index]->parents = $collection->parents();
            $collections[$index]->name = ($collections[$index]->parents!='')?$collections[$index]->parents . "->" . $collections[$index]->name : $collections[$index]->name;
        }
        $product = Product::where('id', $id)->where('is_deleted', false)->first();
        if($product==null){
            $request->session()->flash("msg_error", "محصول مورد نظر پیدا نشد!");
            return redirect()->route('products');
        }

        if($request->getMethod()=='GET'){
            return view('products.create', [
                "collections"=>$collections,
                "product"=>$product
            ]);
        }

        $product->name = $request->input('name', '');
        $product->collections_id = (int)$request->input('collections_id', 0);
        $product->price = (int)$request->input('price', 0);
        $product->save();

        $request->session()->flash("msg_success", "محصول با موفقیت ویرایش شد.");
        return redirect()->route('products');
    }

    public function delete(Request $request, $id)
    {
        $product = Product::where('id', $id)->where('is_deleted', false)->first();
        if($product==null){
            $request->session()->flash("msg_error", "محصول مورد نظر پیدا نشد!");
            return redirect()->route('products');
        }

        $product->is_deleted = true;
        $product->save();

        $request->session()->flash("msg_success", "محصول با موفقیت حذف شد.");
        return redirect()->route('products');
    }

    //---------------------API------------------------------------
    public function apiAddProducts(Request $request){
        $products = $request->input('products', []);
        $ids = [];
        $fails = [];
        foreach($products as $product){
            if(!isset($product['name']) || !isset($product['collections_id'])){
                $fails[] = $product;
                continue;
            }
            if(isset($product['woo_id']) && (int)$product['woo_id']>0) {
                $productObject = Product::where('woo_id', (int)$product['woo_id'])->first();
                if($productObject == null) {
                    $productObject = new Product;
                }
            }else {
                $productObject = new Product;
            }
            foreach($product as $key=>$value){
                $productObject->$key = $value;
            }
            try{
                $productObject->save();
                $ids[] = $productObject->id;
            }catch(Exception $e){
                $fails[] = $product;
            }
        }
        return [
            "added_ids" => $ids,
            "fails" => $fails
        ];
    }

    public function apiDeleteProducts(Request $request){
        $products = $request->input('products', []);
        $ids = [];
        $fails = [];
        foreach($products as $product){
            if(!isset($product['woo_id'])){
                $fails[] = $product;
                continue;
            }
            $productObject = Product::where('woo_id', $product['woo_id'])->with('classrooms')->first();
            if($productObject!=null){
                $productObject->is_deleted = true;
                $productDelete = false;
                try{
                    $productObject->save();
                    $ids[] = $productObject->id;
                    $productDelete = true;
                }catch(Exception $e){
                    $fails[] = $product;
                }
                if($productDelete) {
                    if($productObject->classrooms) {
                        foreach($productObject->classrooms as $classroom) {
                            $classRoomObject = ClassRoom::where('id', $classroom->id)->first();
                            $classRoomDeleted = false;
                            if($classRoomObject) {
                                $classRoomObject->is_deleted = true;
                                $classRoomDeleted = true;
                                try{
                                    $classRoomObject->save();
                                }catch(Exception $e){
                                }
                                if($classRoomDeleted) {
                                    StudentClassRoom::where('class_rooms_id', $classroom->id)->delete();
                                }
                            }
                        }
                    }
                }
            }else {
                $fails[] = $product;
            }
        }
        return [
            "deleted_ids" => $ids,
            "fails" => $fails
        ];
    }
    //---------------------API------------------------------------
    public function apiAddStudents(Request $request){
        $students = $request->input('students', []);
        $ids = [];
        $fails = [];
        foreach($students as $student){
            if(!isset($student['phone']) || !isset($student['last_name'])){
                $fails[] = $student;
                continue;
            }
            $studentObject = new Student;
            foreach($student as $key=>$value){
                $studentObject->$key = $value;
            }
            try{
                $studentObject->save();
                $ids[] = $studentObject->id;
            }catch(Exception $e){
                $fails[] = $student;
            }
        }
        return [
            "added_ids" => $ids,
            "fails" => $fails
        ];
    }
}
