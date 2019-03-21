@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Book') }}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <img src="{{asset($librarySectionBook->avatar)}}" alt="selected Image" id="target" class="img-fluid add-book border border-primary{{ $errors->has('book_avatar') ? ' is-invalid' : '' }} form-control">
                            @if ($errors->has('book_avatar'))
                            <span class="invalid-feedback text-center" role="alert">
                                <strong>{{ $errors->first('book_avatar') }}</strong>
                            </span> @endif
                            <a href="" class="img-select bg-primary text-white" id="img-select">
                                <i class="fa fa-camera"></i>
                            </a>

                        </div>
                        <div class="col-md-8 col-12">
                            <form method="POST" action="{{route('book.update', $librarySectionBook->id)}}" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')

                                <div class="form-group row mt-4">
                                    <div class="col-md-12">
                                     <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $librarySectionBook->name }}"
                                            required autofocus placeholder="Book Name"> @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span> @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <textarea id="description" type="text" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description"
                                        required placeholder="Book Description"> {{$librarySectionBook->description }} </textarea>
                                        @if ($errors->has('description'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('description') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <input id="availableCopies" type="number" class="form-control{{ $errors->has('availableCopies') ? ' is-invalid' : '' }}" name="availableCopies"
                                            value="{{ $librarySectionBook->availableCopies }}" required placeholder="Number of Copies"> </input> @if ($errors->has('availableCopies'))
                                        <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $errors->first('availableCopies') }}</strong>
                                                                            </span> @endif
                                    </div>
                                </div>

                                @if($tags->count() > 0)
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <p>Tags</p>
                                            @foreach($tags as $key => $tag)
                                                <div class="form-check form-check-inline border border-secondary text-secondary rounded px-3 py-2">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox{{$key}}" name="tags[]" value="{{$tag->id}}">
                                                    <label class="form-check-label" for="inlineCheckbox{{$key}}">{{$tag->name}}</label>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                @endif

                                <div class="form-group">
                                    <input type="file" name="book_avatar" id="book_avatar">
                                </div>


                                <div class="form-group row">
                                    <div class="col-md-8 offset-md-2">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Update Book') }}
                                        </button>
                                        <button type="submit" class="btn btn-danger" id="delete_library">
                                            {{ __('Delete') }}
                                        </button>
                                    </div>

                                </div>
                            </form>
                            <form method="POST" action="{{route('book.destroy', $librarySectionBook->id)}}" id="delete_library_form">
                                @csrf @method('DELETE')

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
