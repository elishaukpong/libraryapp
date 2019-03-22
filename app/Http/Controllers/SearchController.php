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
        $this->libraries = $library;
        $this->sections = $librarySection;
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
        $data['searchTerm'] = $request->search;
        $data['searchResults'] = $this->libraries->where('name', 'like', '%' . $request->search . '%')->orWhere('slug', 'like', '%' . $slug . '%')->orderBy('name', 'asc')->paginate(4);
        return view('search.show', $data);

    }

    public function section(Request $request)
    {
        $slug = str_slug($request->search);
        $data['searchTerm'] = $request->search;
        $data['searchResults'] = $this->sections->where('name', 'like', '%' . $request->search . '%')->orWhere('slug', 'like', '%' . $slug . '%')->orderBy('name', 'asc')->paginate(12);
        return view('search.show', $data);
    }

    public function book(Request $request)
    {
        $slug = str_slug($request->search);
        $data['searchTerm'] = $request->search;
        $data['searchResults'] = $this->books->where('name', 'like', '%' . $request->search . '%')->orWhere('slug', 'like', '%' . $slug . '%')->orderBy('name', 'asc')->paginate(12);
        return view('search.show', $data);
    }

}
