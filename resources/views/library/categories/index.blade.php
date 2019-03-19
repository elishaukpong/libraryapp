@extends('layouts.app')

@section('content')
<div class="row">
    @foreach($library->sections as $librarySection)
        <div class="col-md-3 col-12">
            <div class="card">
                <div class="card-body">
                    <h1 class="text-white lib-head mb-4">{{$librarySection->initial}}</h1>
                    <p> <span class="font-weight-bold">Name:</span> {{$librarySection->name}}</p>
                    <p><span class="font-weight-bold">Number Of Books:</span> {{$library->location}}</p>

                    <a href="{{route('section.show', [$library->slug, $librarySection->slug])}}" class="btn btn-sm btn-success">Enter Section</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
