@extends('layouts.app')

@section('content')
<div class="jumbotron text-center my-4">
    <h1>Borrowed Books</h1>
</div>

<div class="row">
    @foreach($borrowedBooks as $libraryBook)
    <div class="col-md-4 col-12 my-4">
        <div class="card">
            <div class="card-body">
                <img src="{{asset($libraryBook->book->avatar)}}" class="img-fluid book-display form-control" alt="">
                <h3 class="text-center my-3">{{$libraryBook->book->name}}</h3>
                <p class="text-center my-3"><span class="font-weight-bold">Book ID:</span> {{$libraryBook->book->book_id}}</p>

                <div class="return">

                </div>
                <a href="#" class="btn btn-sm btn-primary form-control return-book">Return Book</a>
                <a href="{{route('books.return', [$libraryBook->section->library->slug, $libraryBook->section->slug, $libraryBook->book->slug])}}" class="btn btn-sm btn-primary form-control collapse">Return Book</a>

            </div>
        </div>
    </div>
    @endforeach

</div>
<div class="row">
    <div class="col-4 mx-auto my-5">
        {{$borrowedBooks->links()}}
    </div>
</div>
@endsection
