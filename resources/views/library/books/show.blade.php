@extends('layouts.app')

@section('content')
<div class="jumbotron text-center my-4">
    <h1><b>Book:</b> {{$librarySectionBook->name}}</h1>
    <p><b>Library:</b> {{$librarySection->library->name}} /
        <b>Section:</b> {{$librarySection->name}}</p>
</div>

<div class="row">
    <div class="col-md-6 col-12">
        <img src="{{asset($librarySectionBook->avatar)}}" class="img-fluid rounded img-thumbnail " alt="">
    </div>
    <div class="col-md-6 col-12">


                <h1 class="my-3"> {{$librarySectionBook->name}}</h1>

                <div id="{{$librarySectionBook->slug}}" class="my-3">
                    <p>{{$librarySectionBook->description}}</p>
                    <p><span class="font-weight-bold">Book ID:</span>{{$librarySectionBook->book_id}}</p>
                    <p><span class="font-weight-bold">Copies Available:</span> {{$librarySectionBook->availableCopies}}</p>
                    <p><span class="font-weight-bold">Copies Borrowed:</span> {{$librarySectionBook->borrowedCopies}}</p>

                    <a href="{{route('books.borrow', [$library->slug, $librarySection->slug,  $librarySectionBook->slug])}}" class="btn btn-sm btn-success px-4">Borrow</a>
                    <a href="{{route('books.purchase', [$library->slug, $librarySection->slug,  $librarySectionBook->slug])}}" class="btn btn-sm btn-primary px-4">Purchase</a>
                    @auth
                    @if(Auth::user()->isAdmin)
                    <a href="{{route('book.edit', [ $librarySectionBook->book_id])}}" class="btn btn-sm btn-primary">Edit Book</a>
                    @endif
                    @endauth


                </div>

    </div>

        <div class="col-md-6 col-12 my-4">

        </div>



</div>

<div class="row">
    <div class="col-md-6">
        @if($prevBook)
        <div class="float-left">
           <a href="{{route('books.show', [$prevBook->sections->library->slug, $prevBook->sections->slug, $prevBook->slug])}}" class="btn btn-primary">
               <i class="fa fa-chevron-left" aria-hidden="true"></i> &nbsp;&nbsp;
               {{$prevBook->name}}
           </a>
        </div>
        @endif
    </div>
    <div class="col-md-6 float-right">
        @if($nextBook)
        <div class="float-right">
           <a href="{{route('books.show', [$nextBook->sections->library->slug, $nextBook->sections->slug, $nextBook->slug])}}"class="btn btn-primary">
               {{$nextBook->name}} &nbsp;&nbsp;
               <i class="fa fa-chevron-right" aria-hidden="true"></i>
            </a>
        </div>
        @endif
    </div>

</div>


@endsection

