@extends('layouts.app')

@section('content')
<div class="row">
    @foreach($library->sections as $librarySection)
        <div class="col-md-3 col-12">
            <div class="card">
                <div class="card-body">
                    <h1 class="text-white lib-head mb-4">{{$librarySection->initial}}</h1>
                    <p> <span class="font-weight-bold">Name:</span> {{$librarySection->name}}</p>
                    <p><span class="font-weight-bold">Section ID:</span> {{$librarySection->section_id}}</p>
                    <p><span class="font-weight-bold">Number Of Books:</span> {{$librarySection->books()->count()}}</p>

                    <a href="{{route('section.show', [$library->slug, $librarySection->slug])}}" class="btn btn-sm btn-success">Enter Section</a>
                    @if(Auth::user()->isAdmin)
                        <a href="{{route('categories.edit', [$library->slug, $librarySection->slug])}}" class="btn btn-sm btn-primary">EditSection</a>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
    @auth @if(Auth::user()->isAdmin)
    <div class="col-md-3 col-12">
        <div class="card">
            <div class="card-body text-center">

                <h1 class="text-white lib-head mb-4 mt-3">+</h1>
                <br>
                <p> Add New Section</p>

                <a href="{{route('categories.create')}}" class="btn btn-sm btn-success">Add Section</a>
            </div>
        </div>
    </div>
    @endif @endauth
</div>
@endsection
