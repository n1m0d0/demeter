@props([
    'tooltip'
])

<div
    x-data="{ show: false }"
    x-on:mouseover="show = true"
    x-on:mouseleave="show = false"
    {{ $attributes->class(['relative inline-flex w-auto cursor-pointer']) }}>

    <span x-show="show" x-cloak
          x-transition:enter="transition ease-out duration-200"
          x-transition:enter-start="opacity-0 transform scale-90"
          x-transition:enter-end="opacity-100 transform scale-100"
          x-transition:leave="transition ease-in duration-50"
          x-transition:leave-start="opacity-100 transform scale-100"
          x-transition:leave-end="opacity-0 transform scale-90"
          class="bg-gray-800 absolute -mt-5 top-1/2 right-1/2 transform translate-x-1/2 -translate-y-1/2 rotate-45"
          style="width: 10px; height: 10px;"
    ></span>
    <span x-show="show" x-cloak
          x-transition:enter="transition ease-out duration-200"
          x-transition:enter-start="opacity-0 transform scale-90"
          x-transition:enter-end="opacity-100 transform scale-100"
          x-transition:leave="transition ease-in duration-200"
          x-transition:leave-start="opacity-100 transform scale-100"
          x-transition:leave-end="opacity-0 transform scale-90"
          class="text-sm overflow-hidden text-white absolute bg-gray-800 rounded-md px-2 py-1 -mt-8 top-1/2 right-1/2 transform translate-x-1/2 -translate-y-1/2"
    >
        {!! str_replace(' ', '&nbsp;', $tooltip) !!}

    </span>

    {{ $slot }}
</div>