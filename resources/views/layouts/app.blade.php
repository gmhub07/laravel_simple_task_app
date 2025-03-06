<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel Task List App</title>
    {{-- adding tailwind css via cdn --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- adding alpine.js via cdn --}}
    <script src="//unpkg.com/alpinejs" defer></script>

    {{-- this ignore the style tag below when formatting, we are making a custom button style  --}}

    {{-- blade-formatter-disable --}}
    <style type="text/tailwindcss">
        .btn{
            @apply rounded-md px-5 py-2 text-center font-medium shadow-sm ring-1 ring-slate-700/10 hover:bg-slate-50 text-slate-700;
        }

        .link {
            @apply font-medium text-slate-700 underline decoration-pink-500;
        }

        /* defining the label style for the form */
        label{
            @apply block uppercase text-slate-700 mb-2;
        }

        input, textarea {
            @apply shadow-sm appearance-none border w-full py-2 px-3 text-slate-700 leading-tight focus:outline-none;
        }

        .error_message {
            @apply text-red-500 text-sm;
        }
    </style>
    {{-- blade-formatter-enable --}}


    @yield('styles')
</head>
{{-- mx-auto is used to center the content inside the container horizontally, mt-10 is used to add margin at top of the container 10 units. --}}
{{-- max-w-lg is used to set the maximum screen size to large which is equal to 32rem or 512 pixels  --}}
<body class="container mx-auto mt-10 mb-10 max-w-lg">
    <h1 class="text-2xl font-bold mb-4">
        @yield('title')
    </h1>
    {{-- x-data is an alpine component that allows us to create a new component in alpine, flash is a variable that exists within that div --}}
    <div x-data="{flash:true}">
        
        {{-- checking if there is a flash message of success --}}
        @if(session()->has('success'))

        {{-- adding another element of x-show that will show the flash message if the flash variable is true --}}
            <div x-show="flash"class="relative mb-10 rounded border border-green-400 bg-green-100 px-4 py-3 text-lg text-green-700"
            role="alert">
                <strong class="font-bold">Success!</strong>
                {{-- show the sucess message --}}
                <div>{{session('success')}}</div>
            
                <span class="absolute top-0 right-0 bottom-0 px-4 py-3">
                    {{-- adding a vector graphic element of cross to close the flash message --}}
                    {{-- adding the click event listner to the svg element where once clicked it sets the flash variable to false via javascript --}}
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" @click="flash = false"
                    stroke="currentColor" class="h-6 w-6 cursor-pointer">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </span>
            </div>
        @endif

        <div>
            @yield('content')
        </div>
    </div>
</body>
</html>