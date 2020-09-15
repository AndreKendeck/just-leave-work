<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>@yield('title') - Just Leave Work </title>
     <meta name="description" content="Web based Leave Planner" />
     <meta name="csrf-token" content="{{ csrf_token() }}">
     <link href="https://fonts.googleapis.com/css?family=Oxygen&display=swap" rel="stylesheet">
     <link rel="stylesheet" href="{{ asset('css/app.css') }}">
     <script src="{{ asset('js/app.js') }}"></script>
</head>

<body style="font-family: 'Oxygen'" class="bg-gray-100">
     <nav class="w-full lg:p-8 p-3 bg-white text-white border-b-2 border-teal-500" x-data="{ open : false }">
          <div class="flex lg:flex-row flex-col items-center">
               <h2 class="text-extrabold text-teal-500 lowercase text-2xl font-sans w-full">
                    A better leave planner
               </h2>
               <div class="items-center justify-between flex w-full lg:w-1/2 mt-4 lg:mt-0 ">
                    <a href="{{  route('login') }}" class="border-b-2 border-white hover:border-teal-500 px-4 py-2 text-teal-500 mx-1 flex items-center
                    w-full justify-center text-lg">
                         <svg version="1.1" class="stroke-current h-6 w-6 text-teal-500" viewBox="0 0 24 24"
                              xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                              <g fill="none">
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M8.211,9.219v-2.216c0,-2.052 1.537,-3.891 3.586,-3.998c2.185,-0.114 3.993,1.624 3.993,3.784v2.43">
                                   </path>
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M16.5962,9.90381c2.53841,2.53841 2.53841,6.65398 0,9.19239c-2.53841,2.53841 -6.65398,2.53841 -9.19239,0c-2.53841,-2.53841 -2.53841,-6.65398 -8.88178e-16,-9.19239c2.53841,-2.53841 6.65398,-2.53841 9.19239,-1.77636e-15">
                                   </path>
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12,16.5v-2.55"></path>
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M11.997,12.431c-0.414,0 -0.75,0.336 -0.747,0.75c0,0.414 0.336,0.75 0.75,0.75c0.414,0 0.75,-0.336 0.75,-0.75c0,-0.414 -0.336,-0.75 -0.753,-0.75">
                                   </path>
                              </g>
                         </svg>
                         <span class="ml-1">Login</span>
                    </a>
                    <a href="{{ route('register') }}"
                         class="border-b-2 border-white hover:border-teal-500 px-4 py-2 text-teal-500 mx-1 w-full text-center text-lg">
                         Sign
                         Up
                    </a>
                    <a href="{{ route('demo') }}"
                         class=" whitespace-no-wrap border-b-2 border-white hover:border-teal-500 px-4 py-2 text-teal-500 mx-1 w-full text-center text-lg">
                         Demo
                         Preview
                    </a>
               </div>
          </div>
     </nav>
     @yield('content')


</body>

</html>