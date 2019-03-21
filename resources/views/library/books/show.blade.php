@extends('layouts.app')

@section('content')
<div class="row">

        <div class="col-md-6 col-12 my-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-12 mx-auto">
                        <img src="{{asset($librarySectionBook->avatar)}}" class="img-fluid add-book form-control" alt="">

                        </div>
                    </div>
                    <h1 class="text-center my-3">{{$librarySectionBook->name}}</h1>
                    <div id="{{$librarySectionBook->slug}}" class="my-3">
                        <p>{{$librarySectionBook->description}}</p>
                        <p><span class="font-weight-bold">Copies Available:</span> {{$librarySectionBook->availableCopies}}</p>
                        <p><span class="font-weight-bold">Copies Borrowed:</span> {{$librarySectionBook->borrowedCopies}}</p>

                        <a href="{{route('books.borrow', [$library->slug, $librarySection->slug,  $librarySectionBook->slug])}}" class="btn btn-sm btn-success px-4">Borrow</a>
                        <a href="{{route('books.purchase', [$library->slug, $librarySection->slug,  $librarySectionBook->slug])}}" class="btn btn-sm btn-primary px-4">Purchase</a>
                        @if(Auth::user()->isAdmin)
                        <a href="{{route('book.edit', [ $librarySectionBook->book_id])}}" class="btn btn-sm btn-primary">Edit Book</a>
                        @endif


                    </div>
                </div>


                <div id="demo" class="collapse">
                    Lorem ipsum dolor text....
                </div>
            </div>
        </div>



</div>
<div class="row">
    <div class="col-md-6">
        @if($prevBook)
        <div class="float-left">
            <div class="card">
                <div class="card-body">
                    <h1>{{$prevBook->name}}</h1>
                </div>
            </div>
        </div>
        @endif
    </div>
    <div class="col-md-6 float-right">
        @if($nextBook)
        <div class="float-right">
            <div class="card">
                <div class="card-body">
                    <h1>{{$nextBook->name}}</h1>
                </div>
            </div>
        </div>
        @endif
    </div>

</div>

@endsection

