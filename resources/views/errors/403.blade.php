@extends('layouts.web')
@section('title')
Forbidden
@endsection
@section('content')
<div class="flex flex-col mx-4">
    <div class="card p-3 flex flex-col mt-6 w-full lg:w-1/2 self-center items-center">
        <svg version="1.1" viewBox="0 0 24 24" class="stroke-current text-jean w-1/3" xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink">
            <g fill="none">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M10,10.697h4c0.55,0 1,0.45 1,1v3.053c0,0.552 -0.448,1 -1,1h-4c-0.552,0 -1,-0.448 -1,-1v-3.053c0,-0.552 0.448,-1 1,-1Z">
                </path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M10.316,10.697v-1.263c0,-0.93 0.754,-1.684 1.684,-1.684c0.93,0 1.684,0.754 1.684,1.684v1.261">
                </path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M10.476,20.875c6.159,1.01 11.409,-4.239 10.399,-10.399c-0.612,-3.73 -3.62,-6.739 -7.35,-7.351c-6.16,-1.011 -11.41,4.24 -10.399,10.399c0.611,3.731 3.62,6.739 7.35,7.351Z">
                </path>
            </g>
        </svg>
        <h4 class="text-gray-600 text-2xl tracking-wide text-center">
            403
        </h4>
        <h4 class="text-gray-600 text-xl tracking-wide text-center">
            Access denied
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