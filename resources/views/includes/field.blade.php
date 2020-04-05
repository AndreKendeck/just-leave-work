<div class="flex flex-col w-full self-center p-2 ">
     <label for="{{ $name }}" class="text-sm px-2 py-2 text-gray-600">{{ $label ?? '' }}</label>
     <input type="{{ $type ?? 'text' }}" id="{{ $name }}" class="@isset($disabled) bg-gray-400 cursor-not-allowed @endisset" @isset($disabled) disabled="" @endisset name="{{ $name }}"
          value="{{ old($name) ?? $value ?? null }}" @if ($required) required="" @endif>
     @error($name)
     <div class="flex justify-end mx-2 py-1 mt-2 items-center">
          <svg id="warning" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15">
               <path id="Path_41" data-name="Path 41" d="M0,0H15V15H0Z" fill="none" />
               <path id="Path_42" data-name="Path 42"
                    d="M8.625,3h0A5.625,5.625,0,0,1,14.25,8.625h0A5.625,5.625,0,0,1,8.625,14.25h0A5.625,5.625,0,0,1,3,8.625H3A5.625,5.625,0,0,1,8.625,3Z"
                    transform="translate(-1.125 -1.125)" fill="none" stroke="#c81d25" stroke-linecap="round"
                    stroke-linejoin="round" stroke-width="1.5" />
               <path id="Path_43" data-name="Path 43" d="M12,10.625V7.5" transform="translate(-4.5 -2.813)" fill="none"
                    stroke="#c81d25" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
               <path id="Path_44" data-name="Path 44" d="M11.906,16a.156.156,0,1,0,.157.156A.155.155,0,0,0,11.906,16"
                    transform="translate(-4.406 -6)" fill="none" stroke="#c81d25" stroke-linecap="round"
                    stroke-linejoin="round" stroke-width="1.5" />
          </svg>
          <span class="text-red-600 text-xs mx-1">{{ $message }}</span>
     </div>
     @enderror
</div>