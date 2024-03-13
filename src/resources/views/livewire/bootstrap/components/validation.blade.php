@isset($errors)
    <span class="feedback invalid-feedback d-block @if(!$errors->hasAny($input->getErrorKeys())) invisible @endif">
        @error($input->getViewId())
            {{ $message }}
        @else
            @error($input->getViewId() . '.*')
            {{ $message }}
            @enderror
        @enderror
        &nbsp;
    </span>
@endif
