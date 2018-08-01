<input placeholder="{{ isset($placeholder) ? $placeholder : '' }}"
       id="{{ $name }}" name="{{ $name }}"
       type="password"
       class="validate has-character-counter {{ $error ? 'invalid' : '' }}"
       data-length="{{ isset($charLength) ? $charLength : 190 }}"
>
<label for="{{ $name }}">{{ $label }}</label>
@if($error)
    <span class="helper-text" data-error="{{ $error }}" data-success="right">Helper text</span>
@endif