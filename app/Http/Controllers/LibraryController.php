<?php

namespace App\Http\Controllers;

use Auth;
use Faker;
use Session;
use App\Models\Library;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function __construct(Library $library){
        $this->library = $library;
        $this->middleware(['auth', 'admin'])->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['libraries'] = $this->library->paginate(8);
        return view('library.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('library.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required | string',
            'location' => 'string | required',
        ];
        $this->validate($request, $rules);

        $request['user_id'] = Auth::id();
        $request['slug'] = str_slug($request->name);
        $request['library_id'] = str_random(2) . rand(10, 90);
        $this->library->create($request->except(['_token']));

        return Redirect()->route('library.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function show($librarySlug)
    {
       $data['library'] = $this->library->whereSlug($librarySlug)->first();
        return view('library.categories.index', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function edit($librarySlug)
    {
        $data['library'] = $this->library->whereSlug($librarySlug)->first();
        return view('library.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Library $library)
    {
        $rules = [
            'name' => 'required | string',
            'location' => 'string | required',
        ];
        $this->validate($request, $rules);

        $library->update($request->except(['_token', '_method']));
        return redirect()->route('library.show', $library->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function destroy(Library $library)
    {
        // get a total list of sections in the library
        $sections =  $library->sections()->get();

        // Iterate over the sections
        foreach($sections as $section){
            // Get all books for a section
            $books = $section->books()->get();

            // Iterate over the books
            foreach($books as $book){

                $borrowedBooks =  $book->borrowed()->get();
                $recentBooks =  $book->recents()->get();

                foreach($borrowedBooks as $borrowedBook){
                // Check if any book remains borrowed
                if($borrowedBook->returned == 0){
                    Session::flash('error', 'Can not delete section until all books are returned!');
                    return redirect()->back();
                }
                $borrowedBook->delete();
            }

            foreach($recentBooks as $recentBook){
                $recentBook->delete();
            }

            }

            $section->delete();
        }
        $library->delete();

        Session::flash('success', 'Library deleted');
        return redirect()->route('library.index');
    }
}
