<?php

namespace App\Http\Controllers;

use App\Models\LibraryBooks;
use App\Models\Tags;
use App\Models\LibrarySection;
use Illuminate\Http\Request;

class LibraryBooksController extends Controller
{

    public function __construct(LibrarySection $librarySection, LibraryBooks $libraryBooks, Tags $tags)
    {
        $this->librarySection = $librarySection;
        $this->libraryBooks = $libraryBooks;
        $this->tags = $tags;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($sectionSlug)
    {
        $data['librarySection'] = $this->librarySection->whereSlug($sectionSlug)->first();
        $data['tags'] = $this->tags->all();
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
            'book_avatar' => 'image | required | max:1024',
            'availableCopies' => 'integer | required'
        ];

        $messages = [
            'book_avatar.required' => 'Common, You gotta attach an image, I know you got one!',
            'name.required' => 'I know this book you wanna add has a name, give it a name, mahn!',
            'description.required' => 'If you can not construct a description, why not copy "about the book?" Do it mahn!'
        ];

        $this->validate($request, $rules, $messages);

        $librarySection = $this->librarySection->whereId($request->library_section_id)->first();

        $image = $request->file('book_avatar');
        $slug = str_slug($request['name']);
        $imageName = $slug . '.' . time() . '.' . $image->getClientOriginalExtension();


        $book = new LibraryBooks;
        $book->name = $request->name;
        $book->description = $request->description;
        $book->slug = $slug;
        $book->avatar = $imageName;
        $book->availableCopies = $request->availableCopies;
        $book->save();

        $request->book_avatar->storeAs('public/avatars/', $imageName);

        $librarySection->books()->attach($book);

        return redirect()->route('section.show',[$librarySection->library->slug,$librarySection->slug]);
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
