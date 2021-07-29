<button type="submit" class="{{ $this->getSaveButtonClasses() }}">
    @if($this->getSaveButtonIconClasses() !== null)
        <i class="{{ $this->getSaveButtonIconClasses() }}"></i>
    @endif
    @lang($this->getSaveButtonLabel())
</button>