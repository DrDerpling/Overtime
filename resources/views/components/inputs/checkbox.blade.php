<label>
    <input type="checkbox"
           class="filled-in"
           id="{{ $name }}"
           @if($checked) checked="checked" @endif
           value="1"
           name="{{ $name }}"
    />
    <span>{{ $label }}</span>
</label>