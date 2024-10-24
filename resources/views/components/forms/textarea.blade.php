@props(['label', 'name'])

@php
    $defaults = [
        'id' => $name,
        'name' => $name,
        'class' => 'rounded-xl bg-black/10 border border-black/10 px-5 pb-8 pt-2 w-full',
    ];
@endphp

<x-forms.field :$label :$name>
    <textarea {{ $attributes($defaults) }}>{{ $attributes->get('value', old($name)) }}</textarea>
</x-forms.field>