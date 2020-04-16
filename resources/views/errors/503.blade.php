@extends('layouts.web')
@section('title')
Not Found
@endsection
@section('content')
<div class="flex flex-col mx-4">
     <div class="card p-3 flex flex-col mt-6 w-full lg:w-1/2 self-center items-center">
          <svg version="1.1" viewBox="0 0 24 24" class="stroke-current text-jean w-1/2" xmlns="http://www.w3.org/2000/svg"
               xmlns:xlink="http://www.w3.org/1999/xlink">
               <g stroke-linecap="round" stroke-width="1.5" fill="none" stroke-linejoin="round">
                    <path d="M11.835,15l5,5c0.828,0.828 2.172,0.828 3,0v0c0.828,-0.828 0.828,-2.172 0,-3l-5,-5"></path>
                    <path
                         d="M20.916,5.847c0.024,0.023 0.042,0.053 0.051,0.085c0.47,1.567 0.106,3.33 -1.132,4.568c-1.251,1.251 -3.038,1.609 -4.617,1.117l-8.347,8.347c-0.813,0.813 -2.139,0.874 -2.98,0.09c-0.884,-0.823 -0.902,-2.207 -0.056,-3.054l8.383,-8.383c-0.492,-1.579 -0.134,-3.366 1.117,-4.617c1.238,-1.238 3.001,-1.602 4.568,-1.132c0.032,0.01 0.062,0.027 0.085,0.051l0.162,0.162c0.078,0.078 0.078,0.205 0,0.283l-2.635,2.636l2.32,2.32l2.636,-2.636c0.078,-0.078 0.205,-0.078 0.283,0l0.162,0.163Z">
                    </path>
                    <path
                         d="M2.933,4.293l0.674,2.023c0.136,0.409 0.518,0.684 0.949,0.684h2.279v-2.279c0,-0.43 -0.275,-0.813 -0.684,-0.949l-2.023,-0.674c-0.18,-0.06 -0.378,-0.013 -0.512,0.121l-0.562,0.562c-0.134,0.134 -0.181,0.332 -0.121,0.512Z">
                    </path>
                    <path d="M6.84,7l3.5,3.5"></path>
               </g>
          </svg>
          <h4 class="text-gray-600 text-2xl tracking-wide text-center">
               503
          </h4>
          <h4 class="text-gray-600 text-xl tracking-wide text-center">
               Service Unavailable, we probably under maintenance.
          </h4>
          <p class="text-gray-600 mt-3"> Please mail <a
                    href="mailto:support@justleave.work?subject=Error%20on%20Justleave" class="text-jean">Support</a>
               if the problem persists.
          </p>
     </div>
</div>
@endsection