@extends('layouts.app')

@section('title', 'List of Tasks')

@section('content')
    {{-- adding the link to create a new task --}}
    <nav class="mb-4">
        <a href="{{ route('task.create')}}" class="link">Create Task</a>
    </nav>

    <!-- THis all can be replaced with forelse directive -->
        {{-- @if (count($tasks)> 0)
            <div>There are {{count($tasks)}} tasks! </div><br/>
            @foreach ($tasks as $task)
                <div>{{$task->title}}</div>
            @endforeach
        @else
            <div>There are no tasks!</div>
        @endif --}}

        {{-- using endforelse directive --}}
        @forelse ($tasks as $task)
            {{-- <div>{{$task->title}}</div> --}}
            <div>
                {{-- old method to get the task details --}}
                {{-- <a href="{{ route('task.show', ['id' => $task->id])}}">{{$task->title}}</a> --}}

                {{-- using implicit binding now --}}
                {{-- adding the blade directive of the @class to make a strike through effect when the task is completed --}}
                <a href="{{ route('task.show', ['task' => $task->id])}}" @class(['line-through' => $task->completed])>{{$task->title}}</a>
            </div>
        @empty
            <div>There are no tasks!</div>
        @endforelse
        
        {{-- check if the tasks exists then show the pagination links --}}
        @if ($tasks->count())
            <nav class="mt-4">
                {{ $tasks->links() }}
            </nav>
        @endif
    <!-- showing the value passed from the route to the blade template -->
    <!-- using isset directtive to check if the variable is set or not -->
 {{-- @isset($name)
    <div>Hello {{$name}} !</div>
 @endisset --}}



 @endsection