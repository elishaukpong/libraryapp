<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\Models\BorrowBooks;
use App\Models\Library;
use App\Models\LibraryBooks;
use Illuminate\Http\Request;
use App\Models\LibrarySection;

class BorrowBooksController extends Controller
{
    public function __construct(Library $library, LibrarySection $librarySection, LibraryBooks $libraryBooks)
    {
        $this->library = $library;
        $this->librarySection = $librarySection;
        $this->libraryBooks = $libraryBooks;

        $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['borrowedBooks'] = BorrowBooks::whereUserId(Auth::id())->whereReturned(0)->get();

        return view('library.books.borrowed_index', $data);
    }




    public function borrow($librarySlug, $librarySectionSlug, $libraryBooksSlug)
    {
        $library = $this->library->whereSlug($librarySlug)->first();
        $librarySection = $library->sections()->whereSlug($librarySectionSlug)->first();
        $librarySectionBook = $librarySection->books()->whereSlug($libraryBooksSlug)->first();

        if(Auth::user()->borrowedBooks()->whereReturned(0)->count() == 3){
            Session::flash('You cannot borrow more than 3 books at a time!');
            return redirect()->back();
        }

        $borrowedBookId = Auth::user()->borrowedBooks()->whereReturned(0)->get()->pluck('book_id')->toArray();
        if(in_array($librarySectionBook->id, $borrowedBookId)){
            Session::flash('You cannot borrow a book twice!');
            return redirect()->back();
        }

        $borrowedBook = new BorrowBooks;
        $borrowedBook->book_id = $librarySectionBook->id;

        Auth::user()->borrowedBooks()->save($borrowedBook);
        $librarySectionBook->update([
            'availableCopies' => $librarySectionBook->availableCopies - 1,
            'borrowedCopies' => $librarySectionBook->borrowedCopies + 1,
        ]);

        return redirect()->back();
    }

    public function return($librarySlug, $librarySectionSlug, $libraryBooksSlug)
    {
        $library = $this->library->whereSlug($librarySlug)->first();
        $librarySection = $library->sections()->whereSlug($librarySectionSlug)->first();
        $librarySectionBook = $librarySection->books()->whereSlug($libraryBooksSlug)->first();


        $borrowedBook = BorrowBooks::whereBookId($librarySectionBook->id)->whereReturned(0)->first();
        $borrowedBook->update([
            'returned' => 1,
        ]);

        $librarySectionBook->update([
            'availableCopies' => $librarySectionBook->availableCopies + 1,
            'borrowedCopies' => $librarySectionBook->borrowedCopies - 1,
        ]);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BorrowBooks  $borrowBooks
     * @return \Illuminate\Http\Response
     */
    public function show(BorrowBooks $borrowBooks)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BorrowBooks  $borrowBooks
     * @return \Illuminate\Http\Response
     */
    public function edit(BorrowBooks $borrowBooks)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BorrowBooks  $borrowBooks
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BorrowBooks $borrowBooks)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BorrowBooks  $borrowBooks
     * @return \Illuminate\Http\Response
     */
    public function destroy(BorrowBooks $borrowBooks)
    {
        //
    }
}
