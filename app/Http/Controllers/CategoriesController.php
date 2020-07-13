<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Resources\CategoryResource;

use Illuminate\Support\Facades\Auth; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CategoriesController extends Controller
{


    /**
     * Create a new controller instance.
     *
     * @return void
     */

    // access these function only is user is authenticated
    public function __construct()
    {
        $this->middleware('auth'); 
    }

    //get all categories
    public function index(){
        $categories = Auth::user()->categories;
        return  CategoryResource::collection($categories);
         
    }

    // create a category
    public function store(Request $request){
        $this->CreateCategoryValidate($request);

        $category = Auth::user()->categories()->create($request->all());
        return new  CategoryResource($category);
         
    }

    //check if user is aauthotized to delete a category if yes deleted or throw a 403 error
    public function destroy(String $category){
        $category = $this->checkCategory($category); 
        $category ?: exit();
        
        $category->delete();
    }


    //check if user is authorized to update a category is yes upated it if no throw a 403 error
    public function update(Request $request,String $category){
        $category = $this->checkCategory($category); 
        $category ?: exit();

        $this->CreateCategoryValidate($request);
        $category_updated = tap($category)->update($request->all()); 
        return new  CategoryResource($category_updated);
    }



     //validation for category
     public function CreateCategoryValidate($request)
     {
         //validate incoming request 
         return  $this->validate($request, [
             'name' => 'required', 
         ]);
     }

}
