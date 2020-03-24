@extends('layouts.web')
@section('title')
Login
@endsection
@section('content')
<div class="flex flex-col lg:flex-row items-center h-screen mx-4">
     <div class="lg:w-1/2 flex justify-center">
          <svg id="Background_Object_Table_2" data-name="Background Object / Table / 2"
               xmlns="http://www.w3.org/2000/svg" class="w-full" viewBox="0 0 194 147">
               <g id="Group_36" data-name="Group 36" transform="translate(34.899 20.234)">
                    <path id="Stroke_1" data-name="Stroke 1" d="M9.426,19.98,0,0" transform="translate(23.894 11.92)"
                         fill="none" stroke="#cce3ff" stroke-miterlimit="10" stroke-width="12" />
                    <path id="Stroke_2" data-name="Stroke 2" d="M19.888,0,0,11.375" transform="translate(23.894 0.545)"
                         fill="none" stroke="#cce3ff" stroke-miterlimit="10" stroke-width="12" />
                    <path id="Stroke_4" data-name="Stroke 4" d="M0,.5H8.112" transform="translate(43.551 0.291)"
                         fill="none" stroke="#cce3ff" stroke-miterlimit="10" stroke-width="12" />
                    <path id="Fill_6" data-name="Fill 6"
                         d="M0,2.913H17.688A2.913,2.913,0,0,0,14.775,0H2.913A2.913,2.913,0,0,0,0,2.913"
                         transform="translate(27.255 30.804)" fill="#dceeff" />
                    <path id="Fill_8" data-name="Fill 8" d="M14.905,7.453A7.453,7.453,0,1,0,0,7.453"
                         transform="translate(44.21 0)" fill="#dceeff" />
                    <path id="Fill_10" data-name="Fill 10" d="M0,68.39H1.67L11.935,0H6.159Z"
                         transform="translate(6.751 38.646)" fill="#b6d4ff" />
                    <path id="Fill_12" data-name="Fill 12" d="M0,68.39H1.67L11.935,0H6.159Z"
                         transform="translate(35.994 38.646)" fill="#b6d4ff" />
                    <path id="Fill_14" data-name="Fill 14" d="M5.859,0H30.831L24.972,19.319H0Z"
                         transform="translate(71.109 12.78)" fill="#dceeff" />
                    <path id="Fill_16" data-name="Fill 16" d="M27.349,0l-5,16.5H0L5,0Z"
                         transform="translate(72.833 14.022)" fill="#fff" />
                    <path id="Fill_18" data-name="Fill 18" d="M18.582,0l-.238.789H0L.238,0Z"
                         transform="translate(77.522 19.099)" fill="#b6d4ff" />
                    <path id="Fill_20" data-name="Fill 20" d="M17.981,0l-.238.789H0L.238,0Z"
                         transform="translate(76.952 20.706)" fill="#b6d4ff" />
                    <path id="Fill_22" data-name="Fill 22" d="M12.977,0l-.238.789H0L.238,0Z"
                         transform="translate(76.398 22.312)" fill="#b6d4ff" />
                    <path id="Fill_24" data-name="Fill 24" d="M0,1.589H24.972V0H0Z" transform="translate(52.849 32.098)"
                         fill="#dceeff" />
                    <path id="Fill_26" data-name="Fill 26" d="M0,1.589H18.251V0H0Z" transform="translate(77.821 32.098)"
                         fill="#ecf6ff" />
                    <path id="Fill_27" data-name="Fill 27" d="M5.859,0H7.394L1.535,19.319H0Z"
                         transform="translate(96.06 12.78)" fill="#ecf6ff" />
                    <path id="Fill_28" data-name="Fill 28" d="M0,4.959H94.331V0H0Z" transform="translate(0 33.687)"
                         fill="#b6d4ff" />
                    <path id="Fill_29" data-name="Fill 29" d="M0,4.959H36.8V0H0Z" transform="translate(87.509 33.687)"
                         fill="#dceeff" />
                    <path id="Fill_30" data-name="Fill 30" d="M10.265,68.39h1.67L5.776,0H0Z"
                         transform="translate(109.377 38.646)" fill="#dceeff" />
                    <path id="Fill_31" data-name="Fill 31" d="M10.265,68.39h1.67L5.776,0H0Z"
                         transform="translate(80.021 38.646)" fill="#dceeff" />
                    <path id="Fill_32" data-name="Fill 32" d="M18.582,0l-.238.789H0L.238,0Z"
                         transform="translate(78.438 15.983)" fill="#b6d4ff" />
                    <path id="Fill_33" data-name="Fill 33" d="M16.58,0l-.238.789H0L.238,0Z"
                         transform="translate(77.998 17.589)" fill="#b6d4ff" />
                    <path id="Fill_34" data-name="Fill 34"
                         d="M3.444,1.036.323,1.414l-.25-.393L.238.663,0,.378,2.916,0l.44.263L2.987.632Z"
                         transform="translate(87.317 12.78)" fill="#b6d4ff" />
               </g>
          </svg>
     </div>
     <div class="card flex flex-col py-8 lg:w-1/2 w-full ">
          <h4 class="text-jean text-xl text-center">Login to your account</h4>
          <form action="{{ route('login')}}" method="POST" class="flex flex-col">
               @csrf
               @field(['name' => 'email' , 'label' => 'Email Address' , 'required' => true ])
               @field(['name' => 'password' , 'label' => 'Password' , 'required' => true , 'type' => 'password' ])
               <button class="bg-jean hover:bg-black rounded-lg px-4 mt-6 py-2 w-1/2 lg:w-1/4 self-center"> Login
               </button>
               <a href="{{ route('password.request') }}" class="rounded-lg px-4 py-2 mt-2 w-1/2 lg:w-1/4  self-center bg-gray-300 text-gray-700
               hover:bg-gray-400
               text-center">
                    Reset Password </a>
               <p class="text-center text-gray-600 mt-6"> Don't have an account? <a class="text-jean"
                         href="{{ route('register') }}"> Sign
                         up </a> </p>
          </form>
     </div>
</div>
@endsection