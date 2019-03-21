@extends('layouts.app')

@section('content')
<div class="row">
    @foreach($borrowedBooks as $libraryBook)
        <div class="col-md-3 col-12 my-4">
            <div class="card">
                <div class="card-body">
                    <img src="{{asset($libraryBook->book->avatar)}}" class="img-fluid add-book form-control" alt="">
                    <h1 class="text-center my-3">{{$libraryBook->book->name}}</h1>
                    <a href="{{route('books.return', [$libraryBook->book->sections()->first()->library->slug, $libraryBook->book->sections()->first()->slug, $libraryBook->book->slug])}}" class="btn btn-sm btn-primary form-control">Return Book</a>
                    {{-- <button type="button" class="btn btn-primary btn-sm form-control" data-toggle="collapse" data-target="#{{$libraryBook->slug}}">
                        See More
                    </button> --}}
                    {{-- <div id="{{$libraryBook->slug}}" class="collapse my-3">
                        <p>{{$libraryBook->description}}</p>
                        <p><span class="font-weight-bold">Copies Available:</span> {{$libraryBook->availableCopies}}</p>
                        <p><span class="font-weight-bold">Copies Borrowed:</span> {{$libraryBook->borrowedCopies}}</p>

                        <a href="#" class="btn btn-sm btn-success px-4">Borrow</a>
                        <a href="#" class="btn btn-sm btn-primary px-4">Purchase</a>
                    </div> --}}
                </div>
            </div>
        </div>
    @endforeach

</div>
@endsection
