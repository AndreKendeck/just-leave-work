@switch($type)
@case('primary')
<button
    class="w-full rounded-md bg-purple-500 p-2 text-white font-bold text-md  focus:outline-none {{ $disabled ? 'bg-opacity-50 cursor-not-allowed' : "hover:bg-purple-400"  }}"
    {{ $disabled ? "disabled" : null }}>
    {{$slot}}
</button>
@break
@case('soft')
<button
    class="w-full rounded-md bg-gray-300 p-2 text-gray-600 font-bold text-md  focus:outline-none {{ $disabled ? 'bg-opacity-50 cursor-not-allowed' : "hover:bg-gray-200" }}"
    {{ $disabled ? "disabled" : null }}>
    {{$slot}}
</button>
@break
@case('secondary')
<button
    class="w-full rounded-md text-purple-500 p-2 font-bold text-md  focus:outline-none {{ $disabled ? 'bg-opacity-50 cursor-not-allowed' : "hover:bg-gray-200"}}"
    {{ $disabled ? "disabled" : null }}>
    {{$slot}}
</button>
@break
@case('danger')
<button
    class="w-full rounded-md bg-red-600 p-2 text-white font-bold text-md  focus:outline-none {{ $disabled ? 'bg-opacity-50 cursor-not-allowed' : "hover:bg-red-500" }}"
    {{ $disabled ? "disabled" : null }}>
    {{$slot}}
</button>
@break
@default
<button
    class="w-full rounded-md bg-purple-500 p-2 text-white font-bold text-md  focus:outline-none {{ $disabled ? 'bg-opacity-50 cursor-not-allowed' : "hover:bg-purple-400" }}"
    {{ $disabled ? "disabled" : null }}>
    {{$slot}}
</button>
@endswitch