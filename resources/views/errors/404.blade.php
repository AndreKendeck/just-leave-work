@extends('layouts.web')
@section('title')
Not Found
@endsection
@section('content')
<div class="flex flex-col mx-4">
     <div class="card p-3 flex flex-col mt-6 w-full lg:w-1/2 self-center items-center">
          <svg version="1.1" viewBox="0 0 24 24" class="stroke-current w-1/3 text-jean"
               xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
               <g stroke-linecap="round" stroke-width="1.5" fill="none" stroke-linejoin="round">
                    <path
                         d="M19,6.94h-6.471c-0.331,0 -0.641,-0.164 -0.827,-0.438l-1.405,-2.065c-0.186,-0.273 -0.495,-0.437 -0.826,-0.437h-4.471c-1.105,0 -2,0.895 -2,2v12c0,1.105 0.895,2 2,2h14c1.105,0 2,-0.895 2,-2v-9.06c0,-1.104 -0.895,-2 -2,-2Z">
                    </path>
                    <path d="M13.94,11.43l-3.89,3.88"></path>
                    <path d="M10.05,11.43l3.89,3.88"></path>
               </g>
          </svg>
          <h4 class="text-gray-600 text-2xl tracking-wide text-center">
               404
          </h4>
          <h4 class="text-gray-600 text-xl tracking-wide text-center">
               We havent found anything with that URL | Not found
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
     </div>
</div>
@endsection