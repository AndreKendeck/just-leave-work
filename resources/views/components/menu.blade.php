@guest
<div x-data="{ open : false }" class="md:hidden">
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
@endguest