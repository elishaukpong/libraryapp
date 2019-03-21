<?php

namespace App\Http\Controllers;

use Auth;
use Faker;
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
        $data['libraries'] = $this->library->all();
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
       $data['library'] = $this->library->whereSlug($librarySlug)->with('sections')->first();
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
        return $librarySlug;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function destroy(Library $library)
    {
        //
    }
}
