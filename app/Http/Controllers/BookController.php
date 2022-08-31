<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use DB;

class BookController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $book= new Book();

            $book['name']=$request->name;
            $book['author']=$request->author;
            $book['price']=$request->price;
            if($request->file('cover')){
                $file= $request->file('cover');
                $fileName= date('YmdHi').$file->getClientOriginalName();
                $file-> move(public_path('public/Image'), $fileName);
                $book['cover']= $fileName;
            }
            $book->save();

            return redirect()->route('home');
        } catch (\Throwable $th) {
            //throw $th;
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {

            $name_edit = $request->name;
            $price_edit = $request->price;
            $author_edit = $request->author;
            if($request->file('cover')){
                $file= $request->file('cover');
                $fileName= date('YmdHi').$file->getClientOriginalName();
                $file-> move(public_path('public/Image'), $fileName);
                $cover_edit = $fileName;
                $update = [

                    'name' => $name_edit,
                    'price' => $price_edit,
                    'author' => $author_edit,
                    'cover' => $cover_edit
                ];
            }
            else {
                $update = [

                    'name' => $name_edit,
                    'price' => $price_edit,
                    'author' => $author_edit,
                ];
            }
            Book::where('id', $request->id)->update($update);
            DB::commit();
            return redirect()->route('home');
        } catch (\Exception$e) {
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {

            Book::destroy($request->id);

            return redirect()->route('home');

        } catch (\Exception$e) {
            return redirect()->back();
        }
    }




       /**
     * Write code on Method
     *
     * @return response()
     */
    public function cart()
    {
        return view('checkout');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function addToCart($id)
    {
        $book = Book::findOrFail($id);

        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity'];
        } else {
            $cart[$id] = [

                "book_id" => $book->id,
                "name" => $book->name,
                "quantity" => 1,
                "price" => $book->price,
                "image" => $book->cover
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function updateCart(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
        }
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function removeCart(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product removed successfully');
        }
    }
}