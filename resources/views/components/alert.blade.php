@if (session('message'))
<div class="bg-aqua w-screen flex justify-between items-center px-2 py-3" x-data="{ removed : false }"
     x-show="!removed">
     <svg version="1.1" viewBox="0 0 24 24" class="h-8 w-8 stroke-current text-blue-800"
               xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
               <g fill="none">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                         d="M11.999,8c-0.138,0 -0.25,0.112 -0.249,0.25c0,0.138 0.112,0.25 0.25,0.25c0.138,0 0.25,-0.112 0.25,-0.25c0,-0.138 -0.112,-0.25 -0.251,-0.25">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                         d="M12,21v0c-4.971,0 -9,-4.029 -9,-9v0c0,-4.971 4.029,-9 9,-9v0c4.971,0 9,4.029 9,9v0c0,4.971 -4.029,9 -9,9Z">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12,12v5"></path>
               </g>
          </svg>
     <span class="text-jean text-center"> {{ session('message') }} </span>
     <a href="#" class="p-1 hover:bg-blue-100 rounded" x-on:click="removed = true">
          <svg version="1.1" class="h-8 w-8 stroke-current text-blue-800" viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
          <g fill="none">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8,8l8,8"></path>
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16,8l-8,8"></path>
          </g>
     </svg>
     </a>
</div>

@endif


