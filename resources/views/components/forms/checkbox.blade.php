@props(['label', 'name', 'value' => 1, 'checked' => false])

@php
    $defaults = [
        'type' => 'checkbox',
        'id' => $name,
        'name' => $name,
        'value' => $value,
    ];
@endphp

<x-forms.field :$label :$name>
    <div class="rounded-xl bg-white/10 border border-white/10 px-5 w-full">
        <input {{ $attributes($defaults) }} @if($checked) checked @endif>
        <span class="pl-1">{{ $label }}</span>
    </div>
</x-forms.field>