<label>
    <input type="checkbox"
           class="filled-in"
           id="{{ $name }}"
           @if(isset($checked) && $checked) checked="checked" @endif
           value="{{ isset($slot) ? $slot : 1 }}"
           name="{{ $name }}"
    />
    <span>{{ $label }}</span>
</label>