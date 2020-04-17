@extends('layouts.web')
@section('title')
Server Error
@endsection
@section('content')
<div class="flex flex-col mx-4">
     <div class="card p-3 flex flex-col mt-6 w-full lg:w-1/2 self-center items-center">
          <svg version="1.1" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
               class="stroke-current w-1/3 text-jean" xmlns:xlink="http://www.w3.org/1999/xlink">
               <g fill="none">
                    <path d="M0,0h24v24h-24v-24Z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.99,17.76l-0.5,-6.4">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                         d="M18,15h-12c-1.657,0 -3,1.343 -3,3v0c0,1.657 1.343,3 3,3h12c1.657,0 3,-1.343 3,-3v0c0,-1.657 -1.343,-3 -3,-3Z">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                         d="M14.191,5h-8.34c-1.045,0 -1.913,0.804 -1.994,1.845l-0.847,10.912"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                         d="M18.792,3.02l3.046,5.414c0.75,1.333 -0.213,2.981 -1.743,2.981h-6.091c-1.53,0 -2.493,-1.647 -1.743,-2.981l3.046,-5.414c0.763,-1.36 2.72,-1.36 3.485,4.44089e-16Z">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.049,6.835v-1.835">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                         d="M17.048,8.859c-0.05,0 -0.091,0.041 -0.09,0.091c0,0.05 0.041,0.091 0.091,0.091c0.05,0 0.09,-0.041 0.09,-0.091c0,-0.05 -0.04,-0.091 -0.091,-0.091">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18,18h-7"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                         d="M6.035,17.965c0.02,0.02 0.02,0.051 0,0.071c-0.02,0.02 -0.051,0.02 -0.071,0c-0.02,-0.02 -0.02,-0.051 0,-0.071c0.02,-0.02 0.052,-0.02 0.071,0">
                    </path>
               </g>
          </svg>
          <h4 class="text-gray-600 text-2xl tracking-wide text-center">
               500
          </h4>
          <h4 class="text-gray-600 text-xl tracking-wide text-center">
               Something went wrong, we are sorry.
          </h4>
          <a href="{{ url()->previous() }}" class="p-2 bg-gray-300 hover:bg-gray-400 text-gray-600 mt-4 rounded flex ">
               <svg version="1.1" class="stroke-current text-gray-600 w-6 h-6" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <g stroke-linecap="round" stroke-width="2" fill="none" stroke-linejoin="round">
                         <path d="M5,12h14"></path>
                         <path d="M10,7l-5,5"></path>
                         <path d="M10,17l-5,-5"></path>
                    </g>
               </svg>
               <span> Return </span>
          </a>
          <p class="text-gray-600 mt-3"> Please mail <a
                    href="mailto:support@justleave.work?subject=Error%20on%20Justleave" class="text-jean">Support</a>
               if the problem persists.
          </p>
     </div>
</div>
@endsection