<input placeholder="{{ isset($placeholder) ? $placeholder : '' }}"
       id="{{ $name }}" name="{{ $name }}"
       type="text"
       value="{{ $slot }}"
       class="validate has-character-counter {{ $error ? 'invalid' : '' }}"
       data-length="{{ isset($charLength) ? $charLength : 190 }}"
>
<label for="{{ $name }}">{{ $label }}</label>
@if($error)
    <span class="helper-text" data-error="{{ $error }}">Helper text</span>
@endif