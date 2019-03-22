@extends('layouts.home.app')
@section('content')
<div class="s">
    <div class="s-cover">
        <div class="row">
            <div class="col-12 mx-auto">
                <div class="box">

                    <div class="card shadow">
                        <div class="card-body">
                            <a href="#" data-id="library" class="search btn btn-lg form-control btn-success my-3">Library</a>
                            <a href="#" data-id="section" class="search btn btn-lg form-control btn-danger my-3">Section</a>
                            <a href="#" data-id="book" class="search btn btn-lg form-control btn-primary my-3">Book</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>

            <div class="col-6 collapse" id="search">
                <form id="searchForm">
                    <div class="input-group">
                        <input type="text" class="form-control" id="inlineFormInputGroupUsername" placeholder="" name="search" required>
                            <div class="input-group-append">
                                <div class="input-group-text bg-primary text-white search-append">
                                    <i class="fa fa-search" aria-hidden="true"></i> &nbsp; Search
                                </div>
                            </div>
                    </div>
                    <div class="text-center py-2">
                        <p class="small">Start with # when using ID to search</p>
                    </div>
                </for>
            </div>
    </div>

</div>

@endsection


