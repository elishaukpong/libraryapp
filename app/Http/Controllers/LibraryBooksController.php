<?php

namespace App\Http\Controllers;

use App\Models\LibraryBooks;
use App\Models\LibrarySection;
use Illuminate\Http\Request;

class LibraryBooksController extends Controller
{

    public function __construct(LibrarySection $librarySection, LibraryBooks $libraryBooks)
    {
        $this->librarySection = $librarySection;
        $this->libraryBooks = $libraryBooks;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($sectionSlug)
    {
        $data['librarySection'] = $this->librarySection->whereSlug($sectionSlug)->first();
        return view('library.books.create', $data);
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
            'description' => 'required | string',
            'book_avatar' => 'image | required | max:1024'
        ];
        $messages = [
            'book_avatar.required' => 'Common, You gotta attach an image, I know you got one!',
            'name.required' => 'I know this book you wanna add has a name, give it a name, mahn!',
            'description.required' => 'If you can not construct a description, why not copy "about the book?" Do it mahn!'
        ];

        $this->validate($request, $rules, $messages);

        
        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LibraryBooks  $libraryBooks
     * @return \Illuminate\Http\Response
     */
    public function show(LibraryBooks $libraryBooks)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LibraryBooks  $libraryBooks
     * @return \Illuminate\Http\Response
     */
    public function edit(LibraryBooks $libraryBooks)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LibraryBooks  $libraryBooks
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LibraryBooks $libraryBooks)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LibraryBooks  $libraryBooks
     * @return \Illuminate\Http\Response
     */
    public function destroy(LibraryBooks $libraryBooks)
    {
        //
    }
}
