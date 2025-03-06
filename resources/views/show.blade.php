{{-- extends the template --}}
@extends('layouts.app')

@section('title', $task->title)

@section('content')
    {{-- <h1>{{$task->title}}</h1> --}}
    <p class="mb-4 text-slate-700">{{$task->description}}</p>

    @if ($task->long_description)
        <p class="mb-4 text-slate-700">{{$task->long_description}}</p>
    @endif
    {{-- diffForHumans() is used to format the date and time in a human readable format --}}
    <p class="mb-4 text-sm text-slate-700">Task Created at: {{$task->created_at->diffForHumans()}}</p>
    <p class="mb-4 text-sm text-slate-700">Task Updated at: {{$task->updated_at->diffForHumans()}}</p>

    <p class="mb-4">
        Task Status: 
        @if ($task->completed)
            <span class="font-medium text-green-500">Completed</span>
        @else
            <span class="font-medium text-red-500">Not Completed</span>
        @endif
    </p>

    <div class="flex gap-2">
        
        <a href="{{ route('task.edit',['task'=>$task])}}" class="btn">Edit</a>
        
        {{-- laravel is smart it autoamtically fetches the id from the task object so we don't need to specifiy the id --}}
        <form action="{{route('task.destroy',['task'=>$task])}}" method='POST'>
            @csrf
            {{-- using method spoofing to delete the task --}}
            @method('DELETE')
            <button type="submit" class="btn">Delete</button>
        </form>

        <form action="{{ route('task.toggle-complete',['task'=>$task])}}" method="POST">
            @csrf
            @method('PUT')
            <button type="submit" class="btn">Mark as {{ $task->completed ? 'Incomplete' : 'Completed'}}</button>
        </form>

    </div>

    <div class="mt-4">
        {{-- sumbol of arrow left added --}}
        <a href="{{route ('task.index')}}" class="link">&#x2B05 Back to all tasks</a>
    </div>
    {{-- <p>Back to <a href="{{route ('task.index')}}">all tasks</a></p> --}}
@endsection