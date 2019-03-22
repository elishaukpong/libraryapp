<?php

namespace App\Http\Controllers;

use Session;
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
        if(preg_match("/^@.*/", $request->search)){
            $searchResult = $this->retrieveModelById($request->search, 'libraries');

            if(!is_object($searchResult)){
                Session::flash('swal-success', 'No entry found for that Library ID!');
                return redirect()->back();
            }
            Session::flash('swal-success', 'Library Found!');
            return redirect()->route('library.show', $searchResult->slug);
        }


        $slug = str_slug($request->search);
        $data['searchTerm'] = $request->search;
        $data['searchResults'] = $this->libraries->where('name', 'like', '%' . $request->search . '%')->orWhere('slug', 'like', '%' . $slug . '%')->orderBy('name', 'asc')->paginate(4);
        return view('search.show', $data);

    }

    public function section(Request $request)
    {
        if(preg_match("/^@.*/", $request->search)){
            $searchResult = $this->retrieveModelById($request->search, 'sections');

            if(!is_object($searchResult)){
                Session::flash('swal-success', 'No entry found for that Section ID!');
                return redirect()->back();
            }
            Session::flash('swal-success', 'Section Found!');
            return redirect()->route('section.show', [$searchResult->library->slug, $searchResult->slug]);
        }

        $slug = str_slug($request->search);
        $data['searchTerm'] = $request->search;
        $data['searchResults'] = $this->sections->where('name', 'like', '%' . $request->search . '%')->orWhere('slug', 'like', '%' . $slug . '%')->orderBy('name', 'asc')->paginate(12);
        return view('search.show', $data);
    }

    public function book(Request $request)
    {
       if(preg_match("/^@.*/", $request->search)){
            $searchResult = $this->retrieveModelById($request->search, 'books');

            if(!is_object($searchResult)){
                Session::flash('swal-success', 'No entry found for that Book ID!');
                return redirect()->back();
            }
            Session::flash('swal-success', 'Book Found!');
            return redirect()->route('books.show', [$searchResult->sections->library->slug, $searchResult->sections->slug, $searchResult->slug]);
        }

        $slug = str_slug($request->search);
        $data['searchTerm'] = $request->search;
        $data['searchResults'] = $this->books->where('name', 'like', '%' . $request->search . '%')->orWhere('slug', 'like', '%' . $slug . '%')->orderBy('name', 'asc')->paginate(12);
        return view('search.show', $data);
    }

    public function retrieveModelById($searchId, $model){

        $id = str_replace('@', '', $searchId);
        $constraint = 'where' . str_singular($model) . 'Id';
        return $this->$model->$constraint($id)->first();

    }

}
