@guest
<div x-data="{ open : false }" class="lg:hidden">
     <div class="w-screen bg-white flex justify-between">
          <span></span>
          <button class="hamburger hamburger--slider text-sm " x-on:click="open = !open"
               x-bind:class="{ 'is-active' : open }" type="button">
               <span class="hamburger-box text-sm">
                    <span class="hamburger-inner text-sm"></span>
               </span>
          </button>
     </div>
     <div class="bg-white w-screen h-1/4 p-2 transition-all" x-show="open">
          <ul class="flex flex-col items-center">
               <li class="p-3 text-xl text-jean"><a href="{{  route('login') }}"> Login </a></li>
               <li class="p-3 text-xl text-jean"><a href="{{  route('register') }}"> Sign up </a></li>
               <li class="p-3 text-xl text-jean"><a href="{{  route('about') }}"> About </a></li>
               <li class="p-3 text-xl text-jean"><a href="{{  route('terms') }}"> Terms & Conditions </a></li>
          </ul>
     </div>
</div>
<div class="hidden lg:flex p-3 bg-white justify-between w-full">
     <a href="{{ route('index') }}" class="text-lg tracking-widest hover:text-jean"> justleave.work </a>
     <ul class="flex">
          <li> <a href="{{ route('login') }}" class=" text-lg text-gray-700 hover:text-gray-500 mx-2"> Login </a> </li>
          <li> <a href="{{ route('register') }}" class=" text-lg text-gray-700 hover:text-gray-500 mx-2"> Sign up </a>
          </li>
          <li> <a href="{{ route('about') }}" class=" text-lg text-gray-700 hover:text-gray-500 mx-2"> About </a> </li>
     </ul>
</div>
@endguest