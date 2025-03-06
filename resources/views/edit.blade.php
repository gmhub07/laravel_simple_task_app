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
    {{-- using the subview form.blade.php which enhances the usability of the code --}}
   @include('form', ['task' => $task])
@endsection