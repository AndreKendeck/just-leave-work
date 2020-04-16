@if ($paginator->hasPages())

<ul class="flex md:hidden self-center my-6">
     {{-- Previous Page Link --}}
     @if ($paginator->onFirstPage())
     <li class="mx-1 px-3 py-2 bg-gray-200 text-gray-500 rounded">
          <a class="flex items-center font-bold cursor-not-allowed" href="#">
               <span class="mx-1">previous</span>
          </a>
     </li>
     @else
     <li class="mx-1 px-3 py-2 bg-gray-200 text-gray-700 hover:bg-gray-700 hover:text-gray-200 rounded">
          <a class="flex items-center font-bold" href="{{ $paginator->previousPageUrl() }}">
               <span class="mx-1">Previous</span>
          </a>
     </li>
     @endif

     {{-- Next Page Link --}}
     @if ($paginator->hasMorePages())
     <li class="mx-1 px-3 py-2 bg-gray-200 text-gray-700 hover:bg-gray-700 hover:text-gray-200 rounded">
          <a class="flex items-center font-bold" href="{{ $paginator->nextPageUrl() }}">
               <span class="mx-1">Next</span>
          </a>
     </li>
     @else
     <li class="mx-1 px-3 py-2 bg-gray-200 text-gray-500 rounded">
          <a class="flex items-center font-bold cursor-not-allowed" href="#">
               <span class="mx-1">Next</span>
          </a>
     </li>
     @endif
</ul>

@endif