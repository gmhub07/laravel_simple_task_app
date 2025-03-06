@extends('layouts.app')

@section('title','Create Task')

@section('styles')
    <style>
        .error_message{
            color:red;
            font-size: 0.8rem;
        }
    </style>
@endsection

@section('content')
    {{--{{$errors}}--}} <!--this is the error list that is passed from the controller by default, if there is an error, we are redirected back to this page with errors shown as these errors are
    set in the session-->

    
    <!-- Removed the code as this code is including in the form.blade.php as a subview and using the include directive to include the form -->
    @include('form')
@endsection
