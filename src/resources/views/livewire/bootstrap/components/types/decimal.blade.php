<div class="nodus-form-control nodus-form-control-decimal" id="{{ $input->getId(true) }}_container" data-id="{{ $input->getId(true) }}">
    <input type="text"
           id="{{ $input->getId(true) }}"
           name="{{ $input->getName() }}"
           class="form-control @if(isset($errors) && $errors->hasAny($input->getErrorKeys())) is-invalid @endif"
           wire:model.lazy="{{ $input->getViewId() }}"
           data-decimals="{{ $input->getDecimals() }}"
           data-unit="{{ $input->getUnit() ?? '_NO_UNIT' }}"
           @if($input::supports('inputMode') && $input->getInputMode() !== null) inputmode="{{ $input->getInputMode() }}" @endif
    >
    @include('nodus.packages.livewire-forms::livewire.'.config('livewire-forms.theme').'.components.validation')
</div>
