@props(['name', 'is_required' => false, 'attributes' => ''])

@if ($slot)
    <label for="{{ $name }}" class="block text-sm/6 font-medium text-gray-900">
        {{ $slot }}
        @if($is_required)
            <span class="p-0 m-0 text-red-600">*</span>
        @endif
    </label>
@endif
<div class="mt-2">
    <input name="{{ $name }}" id="{{ $name }}"
        {{ $attributes->merge([
                'class' => '
                    block w-full rounded-md bg-white px-3 py-1.5 text-base 
                    text-gray-900 outline-1 -outline-offset-1 outline-gray-300 
                    placeholder:text-gray-400 focus:outline-2 
                    focus:-outline-offset-2 focus:outline-indigo-600 
                    sm:text-sm/6',
            ])->class([
                'disabled:bg-gray-200 disabled:cursor-not-allowed' => $attributes->has('disabled'),
            ]) 
        }}>
</div>
@error($name)
    <span class="error text-red-600 sm:text-sm/6">{{ $message }}</span>
@enderror
