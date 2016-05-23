@extends('layouts/master')

@section('title')
    Welcome!
@endsection

@section('content')
    @include('includes.message-block')
    <div class="row">
        <div class="col-md-6">
            <h3>Sign Up</h3>
            <form action="{{ route('signup') }}" method="post">
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email">E-mail</label>
                    <input id="email" class="form-control" type="email" name="email" value="{{ Request::old('email') }}"></input>
                </div>
                <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                    <label for="email">First Name</label>
                    <input id="first_name" class="form-control" type="text" name="first_name" value="{{ Request::old('first_name') }}"></input>
                </div>
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label for="password">Password</label>
                    <input id="password" class="form-control" type="password" name="password"></input>
                </div>
                <button class="btn btn-primary" type="submit">Submit</button>
                {{-- Add a CSRF protection user Session::token() --}}
                <input type="hidden" name="_token" value="{{ Session::token() }}">
            </form>
        </div>
        <div class="col-md-6">
            <h3>Sign In</h3>
            <form action="{{ route('signin') }}" method="post">
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email">E-mail</label>
                    <input id="email" class="form-control" type="email" name="email"></input>
                </div>
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label for="password">Password</label>
                    <input id="password" class="form-control" type="password" name="password"></input>
                </div>
                <button class="btn btn-primary" type="submit">Submit</button>
                {{-- Add a CSRF protection user Session::token() --}}
                <input type="hidden" name="_token" value="{{ Session::token() }}">
            </form>
        </div>
    </div>
@endsection
