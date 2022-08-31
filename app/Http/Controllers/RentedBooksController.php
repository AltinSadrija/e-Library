<?php

namespace App\Http\Controllers;

use App\Models\RentedBooks;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class RentedBooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $date = Carbon::now()->format('M y');
        $date2 = Carbon::now()->format('y-m');

        $id = Auth::user()->id;
        $rentedBooks = RentedBooks::where('client_id', '=', $id)->get('created_at');
        $rentedBooks2 = RentedBooks::where('client_id', '=', $id)->Where('created_at', '>=', $date2.'-01 00:00:00')->get('book_id');

        $count = 0;
        $same = 0;
        foreach($rentedBooks as $rentedBook){
            if ($rentedBook->created_at->format('M y') == $date) {
                $count++;
            }
        }

        foreach($request->books_id as $book_id)
        {
            foreach($rentedBooks2 as $rentedBook2){
                if ($rentedBook2->book_id == $book_id) {
                    $same++;
                }
            }

            if ($count + count($request->books_id) <=3) {
                if ($same == 0) {
                    RentedBooks::create([
                        'book_id' => $book_id,
                        'client_id' => $request->client_id
                    ]);
                    return redirect()->back()->with('success', 'Books rented successfully!');
                    }
                else {
                    return redirect()->back()->with('error', 'You already rented this book this month!');
                }


            }
            else {
                return redirect()->back()->with('error', 'You tried to rent more than 3 books this month!');

            }
        }
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
     * @param  \App\Models\RentedBooks  $rentedBooks
     * @return \Illuminate\Http\Response
     */
    public function show(RentedBooks $rentedBooks)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RentedBooks  $rentedBooks
     * @return \Illuminate\Http\Response
     */
    public function edit(RentedBooks $rentedBooks)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RentedBooks  $rentedBooks
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RentedBooks $rentedBooks)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RentedBooks  $rentedBooks
     * @return \Illuminate\Http\Response
     */
    public function destroy(RentedBooks $rentedBooks)
    {
        //
    }
}