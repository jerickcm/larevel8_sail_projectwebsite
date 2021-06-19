<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Product;

class ImageStaffProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      echo 'test';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $staff = Staff::find(1);
        $staff->photos()->create(['path' => 'example.jpg']);
    }

    public function createstaff($id)
    {
        $staff = Product::find($id);
        $staff->photos()->create(['path' => 'exampleP.jpg']);
    }

    public function createproduct($id)
    {
        $staff = Staff::find($id);
        $staff->photos()->create(['path' => 'exampleS.jpg']);
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
        //
    }
    public function showstaff($id)
    {
        $staff = Staff::find($id);
        foreach($staff->photos as $photo){
            echo $photo->path." ".$photo->imageble_id." ".$photo->imageable_type.'<br/>';
        }
    }

    public function showproduct($id)
    {
        $product = Product::find($id);
        foreach($product->photos as $photo){
            echo $photo->path." ".$photo->imageble_id." ".$photo->imageable_type.'<br/>';
        }
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
    public function update_staff($id)
    {
        $staff = Staff::find($id);

        // $photo = $staff->photos()->where('imageable_id',1)->first();
        $photo = $staff->photos()->where('id',3)->first();
        $photo->path ="1 Update example.jpg";
        $photo->save();


    }

    public function update_product($id){
        $product = Product::find($id);
        $photo = $product->photos()->where('id',3)->first();
        $photo->path ="1 Update example.jpg";
        $photo->save();

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {


    }
    public function destroy_staff($id)
    {
        $Staff = Staff::find($id);
        $Staff->photos()->where('id',2)->delete();
    }


    public function destroy_product($id)
    {
        $product = Product::find($id);
        var_dump($product );
        $test = $product->photos()->where('id',1)->delete();
        print_r(  $test);
        $test->delete();
    }

    public function assign_product( $id)
    {
        $product = Product::findOrFail($id);
        $photo = \App\Models\Photo::findOrFail(5);

        $product->photos()->save($photo);

    }
    public function assign_staff( $id)
    {
        $Staff = Staff::findOrFail($id);
        $photo = \App\Models\Photo::findOrFail(6);

        $Staff->photos()->save($photo);
    }
}
