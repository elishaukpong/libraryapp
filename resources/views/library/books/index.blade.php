@extends('layouts.app')

@section('content')
<div class="row">
    @foreach($librarySection->books as $libraryBook)
        <div class="col-md-3 col-12 my-4">
            <div class="card">
                <div class="card-body">
                    <img src="{{asset($libraryBook->avatar)}}" class="img-fluid add-book form-control" alt="">
                    <h3 class="text-center my-3">{{$libraryBook->name}}</h3>
                    <p class="text-center my-3"><span class="font-weight-bold">Book ID:</span> {{$libraryBook->book_id}}</p>
                    <a href="{{route('books.show', [$librarySection->library->slug, $librarySection->slug, $libraryBook->slug])}}" class="btn btn-sm btn-primary form-control">See More</a>

                </div>
            </div>
        </div>
    @endforeach
    @auth
    @if(Auth::user()->isAdmin)
    <div class="col-md-3 col-12 my-4">
        <div class="card">
            <div class="card-body text-center">

                <h1 class="text-white lib-head mb-4">+</h1>
                <p> Add Books</p>
                {{--
                <p><span class="font-weight-bold">Number Of Books:</span> {{$library->location}}</p> --}}

                <a href="{{route('books.create', $librarySection->slug)}}" class="btn btn-sm btn-success">Add Books</a>
            </div>
        </div>
    </div>
    @endif
    @endauth

</div>
@endsection
