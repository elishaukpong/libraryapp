<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\Models\Tags;
use App\Models\Library;
use App\Models\Recentbooks;
use App\Models\LibraryBooks;
use Illuminate\Http\Request;
use App\Models\LibrarySection;

class LibraryBooksController extends Controller
{

    public function __construct(Library $library, LibrarySection $librarySection, LibraryBooks $libraryBooks, Tags $tags)
    {
        $this->library = $library;
        $this->librarySection = $librarySection;
        $this->libraryBooks = $libraryBooks;
        $this->tags = $tags;

        $this->middleware(['auth'])->except(['show']);
        $this->middleware(['admin'])->except(['show','borrow','return', 'purchase', 'recent']);
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
        $book->book_id = str_random(5) . rand(10, 90);
        $book->avatar = $imageName;
        $book->availableCopies = $request->availableCopies;

        $request->book_avatar->storeAs('public/avatars/', $imageName);

        $librarySection->books()->save($book);

        return redirect()->route('section.show',[$librarySection->library->slug,$librarySection->slug]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LibraryBooks  $libraryBooks
     * @return \Illuminate\Http\Response
     */
    public function show($librarySlug, $librarySectionSlug, $libraryBooksSlug)
    {
        $library = $this->library->whereSlug($librarySlug)->first();
        $librarySection = $library->sections()->whereSlug($librarySectionSlug)->first();
        $librarySectionBook = $librarySection->books()->whereSlug($libraryBooksSlug)->first();

        // Navigation
        $prevBookId = $librarySection->books()->where('library_books.id', '<', $librarySectionBook->id)
                    ->get()->max('id');
        $nextBookId = $librarySection->books()->where('library_books.id', '>', $librarySectionBook->id)
                    ->get()->min('id');

            $data['library'] = $library;
            $data['librarySection'] = $librarySection;
            $data['librarySectionBook'] = $librarySectionBook;

            $data['prevBook'] = $librarySection->books()->where('library_books.id', '=', $prevBookId)->first();
            $data['nextBook'] = $librarySection->books()->where('library_books.id', '=', $nextBookId)->first();

        // Recent Books;
        $user = Auth::user();

        if($user){

            if($user->recents->count() == 5){
                $user->recents()->first()->delete();
            }

            $recentBookId = $user->recents()->get()->pluck('book_id')->toArray();;

            if(!in_array($librarySectionBook->id, $recentBookId)){
                $recent = new Recentbooks;
                $recent->library_id = $library->id;
                $recent->library_section_id = $librarySection->id;
                $recent->book_id = $librarySectionBook->id;

                Auth::user()->recents()->save($recent);
            }
        }
        return view('library.books.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LibraryBooks  $libraryBooks
     * @return \Illuminate\Http\Response
     */
    public function edit($bookId)
    {
        $data['librarySectionBook'] = $this->libraryBooks->whereBookId($bookId)->first();
        $data['tags'] = $this->tags->all();
        return view('library.books.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LibraryBooks  $libraryBooks
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LibraryBooks $bookId)
    {
        $rules = [
            'name' => 'required | string',
            'description' => 'required | string',
            'book_avatar' => 'image |  max:1024',
            'availableCopies' => 'integer | required'
        ];

        $messages = [
            'name.required' => 'I know this book you wanna add has a name, give it a name, mahn!',
            'description.required' => 'If you can not construct a description, why not copy "about the book?" Do it mahn!'
        ];

        $this->validate($request, $rules, $messages);
        $slug = str_slug($request['name']);

        if($request->hasFile('book_avatar')){
            $image = $request->file('book_avatar');
            $imageName = $slug . '.' . time() . '.' . $image->getClientOriginalExtension();
            $request->book_avatar->storeAs('public/avatars/', $imageName);
            // Storage::disk('public')->delete('/avatars/'.$bookId->avatar);  //not working now
            $bookId->avatar = $imageName;
        }

        $bookId->name = $request->name;
        $bookId->description = $request->description;
        $bookId->slug = $slug;
        $bookId->availableCopies = $request->availableCopies;
        $bookId->update();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LibraryBooks  $libraryBooks
     * @return \Illuminate\Http\Response
     */
    public function destroy(LibraryBooks $bookId)
    {
        $borrowedBooks =  $bookId->borrowed()->get();
        $recentBooks =  $bookId->recents()->get();
        $librarySlug = $bookId->sections->library->slug;
        $sectionSlug = $bookId->sections->slug;

        foreach($borrowedBooks as $borrowedBook){
            // Check if any book remains borrowed
            if($borrowedBook->returned == 0){
                Session::flash('error', 'Can not delete until all books are returned!');
                return redirect()->back();
            }
            $borrowedBook->delete();
        }

        foreach($recentBooks as $recentBook){
            $recentBook->delete();
        }
        $bookId->delete();

        Session::flash('success', 'Book Deleted!');
        return redirect()->route('section.show', [$librarySlug, $sectionSlug]);

    }


}
