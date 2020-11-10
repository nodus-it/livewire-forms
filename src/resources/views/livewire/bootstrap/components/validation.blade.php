<span class="feedback invalid-feedback d-block @if(!$errors->has($input->getViewId())) invisible @endif">
    @error($input->getViewId())
        {{ $message }}
    @enderror
    &nbsp;
</span>
