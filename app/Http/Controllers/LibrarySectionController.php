<?php

namespace App\Http\Controllers;

use App\Models\Library;
use App\Models\LibrarySection;
use Illuminate\Http\Request;

class LibrarySectionController extends Controller
{
     public function __construct(Library $library, LibrarySection $librarySection){
        $this->library = $library;
        $this->librarySection = $librarySection;
        $this->middleware(['auth', 'admin'])->except(['index']);
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
        return view('library.books.index', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LibrarySection  $librarySection
     * @return \Illuminate\Http\Response
     */
    public function edit(LibrarySection $librarySection)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LibrarySection  $librarySection
     * @return \Illuminate\Http\Response
     */
    public function destroy(LibrarySection $librarySection)
    {
        //
    }
}
