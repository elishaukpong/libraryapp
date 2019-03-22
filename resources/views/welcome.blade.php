@extends('layouts.home.app')
@section('content')
<div class="h">
    <div class="h-cover">

        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md text-white">
                    Welcome to <br> Bibliothèque!
                </div>
                <div class="links">
                    <a href="{{route('library.index')}}" class="btn btn-primary">Enter</a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
