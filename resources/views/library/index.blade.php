@extends('layouts.app')

@section('content')
    <div class="jumbotron text-center my-4">
        <h1>Libraries</h1>
    </div>

<div class="row">
    @foreach($libraries as $library)
        <div class="col-md-4 col-12 my-3">
            <div class="card">
                <div class="card-body">
                    <h1 class="text-white lib-head mb-4">{{$library->initial}}</h1>
                    <p> <span class="font-weight-bold">Name:</span> {{$library->name}}</p>
                    <p><span class="font-weight-bold">Library ID:</span> {{$library->library_id}}</p>
                    <p><span class="font-weight-bold">Location:</span> {{$library->location}}</p>

                <a href="{{route('library.show', $library->slug)}}" class="btn btn-sm btn-success form-control">Enter Library</a>
                    @auth
                        @if(Auth::user()->isAdmin)
                            <a href="{{route('library.edit', $library->slug)}}" class="btn btn-sm btn-primary form-control my-2">Edit Library</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    @endforeach


    @auth
        @if(Auth::user()->isAdmin)
            <div class="col-md-3 col-12">
                <div class="card">
                    <div class="card-body text-center">

                        <h1 class="text-white lib-head mb-4 mt-3">+</h1>
                        <br>
                        <p> Add New Library</p>

                        <a href="{{route('library.create')}}" class="btn btn-sm btn-success">Add Library</a>
                    </div>
                </div>
            </div>
        @endif
    @endauth
</div>
<div class="row">
    <div class="col-4 mx-auto my-5">
        {{$libraries->links()}}
    </div>
</div>
@endsection
