@extends('layouts.app')

{{-- check if the task is set, then show the relevant title --}}
@section('title',isset($task) ?'Edit Task': 'Create Task')

{{-- @section('styles')
    <style>
        .error_message{
            color:red;
            font-size: 0.8rem;
        }
    </style>
@endsection --}}

@section('content')
    {{--{{$errors}}--}} <!--this is the error list that is passed from the controller by default, if there is an error, we are redirected back to this page with errors shown as these errors are
    set in the session-->

    {{-- check if the task is set, then it's an update route else it's a create route --}}
    <form method="POST" action="{{ isset($task) ? route('task.update',['task'=>$task->id]) : route('task.store')}}">
        
        {{-- check if the task is set, then it's an update route else it's a create route --}}
        @isset($task)
            @method('PUT')
        @endisset
        
        {{--  using the csrf directive to prevent cross-site request forgery (csrf attack) --}}
        @csrf
        
        <div class="mb-4">
            <label for="title">Title</label>

            {{-- n PHP, the ?? operator is called the null coalescing operator. It was introduced in PHP 7 and is used to check if a variable is set and is not null. If the variable is set and not null, it returns the value of the variable; otherwise, it returns the value on the right-hand side. 
            in the case below even if the title is not set, it will not return any error.--}}


            <input type="text" name="title"id="title" @class(['border-red-500' => $errors->has('title')]) value="{{ $task->title ?? old('title')}}"> <!--old is a helper function that will get the old input from the session in case of an error occurs, this method only works with form having post method-->
            {{-- showing the error message from the error saved in the session --}}
            @error('title')
                <p class="error_message">{{$message}}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="description">Description</label>
            <textarea type="text" name="description"id="description" @class(['border-red-500' => $errors->has('description')]) rows="5">{{ $task->description ??old('description')}}</textarea>
            @error('description')
                <p class="error_message">{{$message}}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="long_description">Long Description</label>
            <textarea type="text" name="long_description"id="long_description" @class(['border-red-500' => $errors->has('long_description')]) rows="10">{{ $task->long_description ??old('long_description')}}</textarea>
            @error('long_description')
                <p class="error_message">{{$message}}</p>
            @enderror
        </div>
        {{-- items-center is used to center the items vertically in the flex container --}}
        <div class=" flex gap-2 items-center mb-4">
            <button type="submit" class="btn">
                @isset($task)
                    Update task
                @else
                    Create task
                @endisset
            </button>
            <a href="{{route('task.index')}}" class="btn">
                Cancel
            </a>
        </div>
    </form>
@endsection