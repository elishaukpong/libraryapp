@extends('layouts.app')

@section('content')
<div class="row">

        <div class="col-md-3 col-12 my-4">
            <div class="card">
                <div class="card-body">
                    <img src="{{asset($librarySectionBook->avatar)}}" class="img-fluid add-book form-control" alt="">
                    <h1 class="text-center my-3">{{$librarySectionBook->name}}</h1>

                    <div id="{{$librarySectionBook->slug}}" class="my-3">
                        <p>{{$librarySectionBook->description}}</p>
                        <p><span class="font-weight-bold">Copies Available:</span> {{$librarySectionBook->availableCopies}}</p>
                        <p><span class="font-weight-bold">Copies Borrowed:</span> {{$librarySectionBook->borrowedCopies}}</p>

                        <a href="#" class="btn btn-sm btn-success px-4">Borrow</a>
                        <a href="#" class="btn btn-sm btn-primary px-4">Purchase</a>
                    </div>
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

