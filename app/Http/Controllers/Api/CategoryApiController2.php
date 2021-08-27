<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
use App\Category;
use App\Product;
use App\ProductColor;
use App\ProductImage;
use App\ProductSize;

class CategoryApiController2 extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         // 10 indicates the number of records
            $cats = Category::where('parent','=','0')
            ->get();
            $categories =  array();
            $i = 0;
            foreach($cats as $cat){

            if($cat->parent == 0){
            $categories[$i]['Parent'] = $cat;

            $childs = Category::where('parent','=',$cat->id)
            ->get();

            $s= 0;
            foreach($childs as $child){

                $categories[$i]['child'][$s] = $child;
                $subchild = Category::where('parent','=',$child->id)
                ->get();

                $categories[$i]['child'][$s]['subchild'] = $subchild;
                $s++;
            }

            }

             $i++;

         }
         return $categories;
    }

    // categories
    public function randomCategories(){

        // 3 indicates the number of records
        $cats = Category::inRandomOrder()->where('parent','=','0')
        ->where('picture','!=','none')
        ->limit(3)->get();
        $categories =  array();
        $i = 0;
        foreach($cats as $cat){
            if($cat->parent == 0){
                $categories[$i]['Parent'] = $cat;

                $childs = Category::where('parent','=',$cat->id)

               ->get();

                $s= 0;
                foreach($childs as $child){

                    $categories[$i]['child'][$s] = $child;
                    $subchild = Category::where('parent','=',$child->id)
                    ->where('picture','!=','none')
                    ->get();

                    $categories[$i]['child'][$s]['subchild'] = $subchild;
                    $s++;
                }

              }

            $i++;

        }
        return $categories;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cats = Category::where('id','=',$id)->get();


        $products =  array();
        $i = 0;
        foreach($cats as $cat){

             $prods =  $cat->product;
             foreach($prods as $prod){

                $prodBrand = Brand::where('id','=',$prod->brand)->first();
                $prodSize = $prod->size;
                $prodColor = $prod->color;
                $prodImage = $prod->image;
                $products[$i] = $prod;

                if($prodBrand == null){
                    $products[$i]['brand'] = "No Brand";
                }else{
                    $products[$i]['brand'] = $prodBrand->name;
                }


                $i++;

            }

            $i++;

        }
        return $cats;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
