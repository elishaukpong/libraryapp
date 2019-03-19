@extends('layouts.app')

@section('content')
<div class="row">
    @foreach($librarySection->books as $libraryBook)
        <div class="col-md-3 col-12">
            <div class="card">
                <div class="card-body">
                    <img src="{{asset($libraryBook->avatar)}}" class="img-fluid add-book form-control" alt="">
                    <h1 class="text-center my-3">{{$libraryBook->name}}</h1>
                    <button type="button" class="btn btn-primary btn-sm form-control" data-toggle="collapse" data-target="#{{$libraryBook->slug}}">
                        See More
                    </button>
                    <div id="{{$libraryBook->slug}}" class="collapse my-3">
                        <p>{{$libraryBook->description}}</p>
                        <p><span class="font-weight-bold">Copies Available:</span> {{$libraryBook->availableCopies}}</p>
                        <p><span class="font-weight-bold">Copies Borrowed:</span> {{$libraryBook->borrowedCopies}}</p>

                        <a href="#" class="btn btn-sm btn-success px-4">Borrow</a>
                        <a href="#" class="btn btn-sm btn-primary px-4">Purchase</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @auth
    @if(Auth::user()->isAdmin)
    <div class="col-md-3 col-12">
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
