@props(['disabled' => false])

<div x-data="{ show: true }" class="text-gray-700">
    <div class="relative">
      <div class="absolute inset-y-0 left-0 pl-3 flex items-center text-sm leading-5">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16l2.879-2.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
      </div>
      <input type="text" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-lg pr-4 pl-10 shadow-sm']) !!}>
    </div>
  </div>
