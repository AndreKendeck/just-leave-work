<div class="flex flex-col space-y-2 w-full">
    <input name={{$name}} type="{{ $type }}" class="form-input w-full placeholder-gray-500 text-gray-600 
        {{ $disabled ? 'bg-gray-300 border-gray-500 border-2 cursor-not-allowed' : null  }}"
        placeholder="{{ $label ?? null }}" {{ $disabled ? "disabled=" : null }} />
    @foreach ($errors->get($name) as $error)
    <ul class="flex flex-col space-y-2">
        <li class="text-red-600 text-sm">{{ $error }}</li>
    </ul>
    @endforeach
</div>