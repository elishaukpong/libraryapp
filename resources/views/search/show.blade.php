@extends('layouts.home.app')

@section('content')
<div class="jumbotron text-center">
    <h1 class="display-4">Search Results</h1>
    @if(\Request::is('search/library*'))
    <h4><b>Library</b></h4>
    @elseif(\Request::is('search/section*'))
    <h4><b>Section</b></h4>
    @else
    <h4><b>Books</b></h4>
    @endif
    <small><b>Search Term:</b> {{$searchTerm}} | <b>Count:</b> {{$searchResults->count()}} | <b>Total Pages: </b> {{$searchResults->lastPage()}} | <b>Current Page: </b>{{$searchResults->currentPage()}} </small>


</div>

<div class="row">
    <div class="col-md-10 col-12 mx-auto">
        <div class="row">
            @foreach($searchResults as $searchResult)
            <div class="col-md-3 col-12 my-3">
                <div class="card">
                    <div class="card-body">

                        @if(\Request::is('search/library*'))
                            <h1 class="text-white lib-head mb-4">{{$searchResult->initial}}</h1>
                            <p> <span class="font-weight-bold">Name:</span> {{$searchResult->name}}</p>
                            <p><span class="font-weight-bold">Library ID:</span> {{$searchResult->library_id}}</p>
                            <p><span class="font-weight-bold">Library Location:</span> {{$searchResult->location}}</p>
                            <a href="{{route('library.show', $searchResult->slug)}}" class="btn btn-sm btn-success form-control">Enter Library</a>

                        @elseif(\Request::is('search/section*'))

                            <h1 class="text-white lib-head mb-4">{{$searchResult->initial}}</h1>
                            <p> <span class="font-weight-bold">Name:</span> {{$searchResult->name}}</p>
                            <p><span class="font-weight-bold">Section ID:</span> {{$searchResult->section_id}}</p>
                            <p><span class="font-weight-bold">Number Of Books:</span> {{$searchResult->books()->count()}}</p>

                            <a href="{{route('section.show', [$searchResult->library->slug, $searchResult->slug])}}" class="btn btn-sm btn-success form-control">Enter Section</a>

                        @else

                            <img src="{{asset($searchResult->avatar)}}" class="img-fluid book-display form-control" alt="">
                            <h3 class="text-center my-3">{{$searchResult->name}}</h3>
                            <p class="text-center my-3"><span class="font-weight-bold">Book ID:</span> {{$searchResult->book_id}}</p>
                            <a href="{{route('books.show', [$searchResult->sections->library->slug, $searchResult->sections->slug,
                             $searchResult->slug])}}" class="btn btn-sm btn-primary form-control">See More</a>

                        @endif
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>

</div>
<div class="row">
    <div class="col-3 mx-auto my-5">
        {{$searchResults->appends(['search' => $searchTerm])->links()}}
    </div>
</div>
@endsection
