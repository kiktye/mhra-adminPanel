@props(['active' => false])

<a class="{{ $active ? 'bg-gray-400 text-shadowed' : 'text-gna hover:bg-gna hover:text-shadowed' }} rounded-md px-3 py-1 text-sm font-semibold block md:inline-block"
    aria-current="{{ $active ? 'page' : 'false' }}" {{ $attributes }}>
    {{ $slot }}</a>
