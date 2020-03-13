@auth
<div class="sticky bottom-0 bg-white py-1 px-2 w-screen md:hidden">
     <ul class="flex justify-around">
          <li class="p-2">
               <a href="{{ route('index') }}" class="flex flex-col ">
                    <svg version="1.1" id="home" viewBox="0 0 24 24"
                         class="stroke-current stroke-0 w-8 h-8 text-gray-800" xmlns="http://www.w3.org/2000/svg"
                         xmlns:xlink="http://www.w3.org/1999/xlink">
                         <g fill="none">
                              <path d="M0,0h24v24h-24Z"></path>
                              <path stroke="#323232" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                   d="M18.364,5.63604c3.51472,3.51472 3.51472,9.2132 0,12.7279c-3.51472,3.51472 -9.2132,3.51472 -12.7279,0c-3.51472,-3.51472 -3.51472,-9.2132 -1.77636e-15,-12.7279c3.51472,-3.51472 9.2132,-3.51472 12.7279,-1.77636e-15">
                              </path>
                              <path stroke="#323232" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                   d="M15.583,10.292l-3.023,-2.115c-0.337,-0.236 -0.785,-0.236 -1.121,0l-3.022,2.115c-0.261,0.183 -0.417,0.482 -0.417,0.801v3.929c0,0.54 0.438,0.978 0.978,0.978h6.044c0.54,0 0.978,-0.438 0.978,-0.978v-3.929c0,-0.319 -0.156,-0.618 -0.417,-0.801Z">
                              </path>
                         </g>
                    </svg>
                    @if(request()->is('/'))
                    <span class="border-b-2 mt-1 border-blue-500"></span>
                    @endif
               </a>
          <li class="p-2">
               <a href="{{ route('leaves.index') }}" class="flex flex-col">
                    <svg version="1.1" id="leave" class="stroke-current stroke-0 w-8 h-8 text-gray-800"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                         xmlns:xlink="http://www.w3.org/1999/xlink">
                         <g stroke-linecap="round" stroke-width="1.5" stroke="#323232" fill="none"
                              stroke-linejoin="round">
                              <path d="M20,21h-16"></path>
                              <path
                                   d="M14.905,3.666v0c3.881,1.647 5.928,5.927 4.774,9.982l-0.075,0.265c-0.328,1.155 -1.594,1.76 -2.699,1.291l-11.688,-4.962c-1.105,-0.469 -1.549,-1.8 -0.946,-2.839l0.138,-0.239c2.116,-3.645 6.616,-5.146 10.496,-3.498Z">
                              </path>
                              <path d="M14.905,3.666l0.259,1.047c0.769,3.115 0.094,6.41 -1.839,8.971v0"></path>
                              <path d="M14.905,3.666l-0.933,0.541c-2.775,1.61 -4.676,4.386 -5.176,7.555v0"></path>
                              <path d="M11.06,12.72l-3.51,8.28"></path>
                         </g>
                         <path fill="none" d="M0,0h24v24h-24Z"></path>
                    </svg>
                    @if(request()->is('/leaves/*'))
                    <span class="border-b-2 mt-2 border-blue-500"></span>
                    @endif
               </a>
          </li>
          <li class="p-2">
               <a href="{{ route('profile') }}" class="flex flex-col">
                    <svg version="1.1" class="fill-current stroke-0 text-gray-800 h-8 w-8" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                         <g stroke-linecap="round" stroke-width="1.4824" stroke="#323232" fill="none"
                              stroke-linejoin="round">
                              <path
                                   d="M5,20v0c0,-2.456 1.991,-4.447 4.447,-4.447h5.106c2.456,0 4.447,1.991 4.447,4.447v0">
                              </path>
                              <path stroke-width="1.5"
                                   d="M15.0052,5.2448c1.65973,1.65973 1.65973,4.35068 0,6.01041c-1.65973,1.65973 -4.35068,1.65973 -6.01041,0c-1.65973,-1.65973 -1.65973,-4.35068 -1.77636e-15,-6.01041c1.65973,-1.65973 4.35068,-1.65973 6.01041,-1.77636e-15">
                              </path>
                         </g>
                         <path fill="none" d="M0,0h24v24h-24Z"></path>
                    </svg>
                    @if(request()->is('/profile/*'))
                    <span class="border-b-2 mt-2 border-blue-500"></span>
                    @endif
               </a>
          </li>
          <li class="p-2">
               <a href="{{ route('settings') }}" class="flex flex-col">
                    <svg version="1.1" viewBox="0 0 24 24" class="stroke-current w-8 h-8 stroke-0"
                         xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                         <g stroke-linecap="round" stroke-width="1.5" stroke="#323232" fill="none"
                              stroke-linejoin="round">
                              <path
                                   d="M3.9,15.647l1.398,0.214c1.032,0.158 1.769,1.082 1.693,2.123l-0.103,1.411c-0.03,0.411 0.194,0.798 0.565,0.977l1.034,0.498c0.371,0.179 0.814,0.112 1.117,-0.167l1.039,-0.96c0.766,-0.708 1.948,-0.708 2.715,0l1.039,0.96c0.303,0.28 0.745,0.346 1.117,0.167l1.036,-0.499c0.37,-0.178 0.593,-0.564 0.563,-0.974l-0.103,-1.413c-0.076,-1.041 0.661,-1.965 1.693,-2.123l1.398,-0.214c0.407,-0.062 0.735,-0.367 0.827,-0.769l0.255,-1.118c0.092,-0.402 -0.071,-0.819 -0.411,-1.051l-1.167,-0.799c-0.861,-0.59 -1.124,-1.742 -0.604,-2.647l0.705,-1.226c0.205,-0.357 0.171,-0.804 -0.086,-1.126l-0.715,-0.897c-0.257,-0.322 -0.685,-0.455 -1.079,-0.334l-1.352,0.414c-0.999,0.306 -2.064,-0.207 -2.448,-1.178l-0.518,-1.313c-0.152,-0.384 -0.523,-0.636 -0.936,-0.635l-1.146,0.003c-0.413,0.001 -0.783,0.255 -0.933,0.64l-0.505,1.298c-0.38,0.977 -1.45,1.494 -2.452,1.186l-1.408,-0.432c-0.395,-0.122 -0.825,0.012 -1.082,0.336l-0.71,0.898c-0.257,0.325 -0.288,0.773 -0.079,1.13l0.721,1.229c0.531,0.906 0.271,2.069 -0.595,2.662l-1.153,0.79c-0.34,0.233 -0.503,0.65 -0.411,1.051l0.255,1.118c0.091,0.403 0.419,0.708 0.826,0.77Z">
                              </path>
                              <path
                                   d="M13.916,10.084c1.058,1.058 1.058,2.774 0,3.832c-1.058,1.058 -2.774,1.058 -3.832,0c-1.058,-1.058 -1.058,-2.774 0,-3.832c1.058,-1.058 2.774,-1.058 3.832,0">
                              </path>
                         </g>
                         <path fill="none" d="M0,0h24v24h-24v-24Z"></path>
                    </svg>
                    @if(request()->is('/settings/*'))
                    <span class="border-b-2 mt-2 border-blue-500"></span>
                    @endif
               </a>
          </li>
          </li>
     </ul>
</div>
@endauth