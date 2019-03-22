<?php

namespace App\Http\Controllers;

use App\Models\Library;
use Illuminate\Http\Request;
use App\Models\LibraryBooks;
use App\Models\LibrarySection;

class SearchController extends Controller
{

    public function __construct(Library $library, LibrarySection $librarySection, LibraryBooks $libraryBooks)
    {
        $this->library = $library;
        $this->section = $librarySection;
        $this->books = $libraryBooks;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('search.index');
    }


    public function library(Request $request)
    {
        $slug = str_slug($request->search);
        $searchResult = $this->library->where('name', 'like', '%' . $request->search . '%')->orWhere('slug', 'like', '%' . $slug . '%')->get();
        return $searchResult;

    }

    public function section(Request $request)
    {
        $slug = str_slug($request->search);
        $searchResult = $this->section->where('name', 'like', '%' . $request->search . '%')->orWhere('slug', 'like', '%' . $slug . '%')->get();
        return $searchResult;
    }

    public function book(Request $request)
    {
        $slug = str_slug($request->search);
        $searchResult = $this->book->where('name', 'like', '%' . $request->search . '%')->orWhere('slug', 'like', '%' . $slug . '%')->get();
        return $searchResult;
    }


    public function store(Request $request)
    {
        //
    }


}
