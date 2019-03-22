<?php

namespace App\Http\Controllers;

use Session;
use App\Models\Library;
use App\Models\LibrarySection;
use Illuminate\Http\Request;

class LibrarySectionController extends Controller
{
     public function __construct(Library $library, LibrarySection $librarySection){
        $this->library = $library;
        $this->librarySection = $librarySection;
        $this->middleware(['auth', 'admin'])->except(['show']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['libraries'] = $this->library->all();
        return view('library.categories.create', $data);
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
            'name' => 'string | required',
            'library_id' => 'integer | required'
        ];
        $this->validate($request, $rules);
        $request['slug'] = str_slug($request->name);
        $request['section_id'] = str_random(3) . rand(10, 90);

        $library = $this->library->whereId($request->library_id)->first();

        $this->librarySection->create($request->except(['_token']));
        return redirect()->route('library.show', $library->slug );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LibrarySection  $librarySection
     * @return \Illuminate\Http\Response
     */
    public function show($librarySlug, $sectionSlug)
    {
        $data['librarySection'] = $this->library->whereSlug($librarySlug)->first()->sections()->whereSlug($sectionSlug)->first();
        $data['librarySectionBooks'] = $data['librarySection']->books()->paginate(8);
        return view('library.books.index', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LibrarySection  $librarySection
     * @return \Illuminate\Http\Response
     */
    public function edit($librarySlug, $sectionSlug)
    {
        $data['librarySection'] = $this->library->whereSlug($librarySlug)->first()->sections()->whereSlug($sectionSlug)->first();
        $data['libraries'] = $this->library->all();
        return view('library.categories.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LibrarySection  $librarySection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LibrarySection $librarySection)
    {
         $rules = [
            'name' => 'string | required',
            'library_id' => 'integer | required'
        ];
        $this->validate($request, $rules);
        $request['slug'] = str_slug($request->name);
        $librarySection->update($request->except(['_token', '_method']));

        return redirect()->route('library.show', $librarySection->library->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LibrarySection  $librarySection
     * @return \Illuminate\Http\Response
     */
    public function destroy(LibrarySection $librarySection)
    {
        $books = $librarySection->books()->get();
        $librarySlug = $librarySection->library->slug;

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

        $librarySection->delete();

        Session::flash('success', 'Section deleted');
        return redirect()->route('library.show', $librarySlug);
    }
}
