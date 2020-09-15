<div class="w-full flex flex-col">
    <label for="{{ $name }}" class="mb-2 text-gray-800 tracking-tight font-bold"> {{ $label ?? '' }} </label>
    <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" {{ $attributes }} class="form-input rounded-none text-gray-800 placeholder-gray-500
    p-3" @if ($placeholder) placeholder="" @endif @if ($required) required="" @endif>
    @if ($errors->has($name))
    @foreach ($errors->get($name) as $error)
    <div class="text-red-500 w-full justify-end flex mt-2">
        {{ $error }}
    </div>
    @endforeach
    @endif
</div>