<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\Models\BorrowBooks;
use App\Models\Library;
use App\Models\LibraryBooks;
use App\Models\LibrarySection;

class BorrowBooksController extends Controller
{
    public function __construct(Library $library, LibrarySection $librarySection, LibraryBooks $libraryBooks)
    {
        $this->library = $library;
        $this->librarySection = $librarySection;
        $this->libraryBooks = $libraryBooks;

        $this->middleware(['auth', 'verified']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['borrowedBooks'] = BorrowBooks::whereUserId(Auth::id())->whereReturned(0)->paginate(8);
        if($data['borrowedBooks']->count() == 0){
            Session::flash('info', 'You haven\'t borrowed any book yet');
            return redirect()->route('library.index');
        }

        return view('library.books.borrowed_index', $data);
    }




    public function borrow($librarySlug, $librarySectionSlug, $libraryBooksSlug)
    {
        $library = $this->library->whereSlug($librarySlug)->first();
        $librarySection = $library->sections()->whereSlug($librarySectionSlug)->first();
        $librarySectionBook = $librarySection->books()->whereSlug($libraryBooksSlug)->first();

        if(Auth::user()->borrowedBooks()->whereReturned(0)->count() == 3){
            Session::flash('swal-info','You cannot borrow more than 3 books at a time!');
            return redirect()->back();
        }

        $borrowedBookId = Auth::user()->borrowedBooks()->whereReturned(0)->get()->pluck('book_id')->toArray();
        if(in_array($librarySectionBook->id, $borrowedBookId)){
            Session::flash('swal-info','You cannot borrow a book twice!');
            return redirect()->back();
        }

        $borrowedBook = new BorrowBooks;
        $borrowedBook->library_id = $library->id;
        $borrowedBook->library_section_id = $librarySection->id;
        $borrowedBook->book_id = $librarySectionBook->id;

        Auth::user()->borrowedBooks()->save($borrowedBook);

        $librarySectionBook->update([
            'availableCopies' => $librarySectionBook->availableCopies - 1,
            'borrowedCopies' => $librarySectionBook->borrowedCopies + 1,
        ]);

        $message = 'You have borrowed ' . $librarySectionBook->name . '. Please, endeavor to return it on or before two weeks!, Thanks';
        Session::flash('swal-success', $message);
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
        Session::flash('success', 'Book Returned!');
        return redirect()->back();
    }

}
