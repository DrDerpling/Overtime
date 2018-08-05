@php
    if (!isset($hours)) {
        $hours = 0;
    }
@endphp


<label>
    <input type="checkbox"
           class="filled-in {{ $hours ? 'hold-time' : '' }}"
           id="{{ $name }}"
           @if($hours)
            data-hours="{{ $hours }}"
           @endif
           @if(isset($checked) && $checked) checked="checked" @endif
           value="{{ isset($slot) ? $slot : 1 }}"
           name="{{ $name }}"
    />
    <span>{{ $label }}</span>
</label>