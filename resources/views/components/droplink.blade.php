@props(['active' => false])

<a class="{{ $active ? 'bg-gna text-shadowed' : 'text-gna hover:bg-gna hover:text-shadowed' }}
rounded-md px-3 py-2 text-sm font-bold flex justify-center items-center"
    aria-current="{{ $active ? 'page' : 'false' }}" {{ $attributes }}>
    {{ $slot }}</a>
