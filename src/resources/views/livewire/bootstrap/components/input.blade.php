<div class="nodus-form-control nodus-form-control-{{$input->getType()}}" id="{{ $input->getId(true) }}_container" data-id="{{ $input->getId(true) }}">
    <input type="{{$input->getType()}}"
           name="{{ $input->getName() }}"
           @if($input::supports('minMax'))
               @if($input->getMin() !== null) min="{{ $input->getMin() }}" @endif
               @if($input->getMax() !== null) max="{{ $input->getMax() }}" @endif
               @if($input->getStep() !== null) step="{{ $input->getStep() }}" @endif
           @endif
           @if($input::supports('placeholder') && $input->hasPlaceholder()) placeholder="{{ $input->getPlaceholder() }}" @endif
           @if($input::supports('inputMode') && $input->getInputMode() !== null) inputmode="{{ $input->getInputMode() }}" @endif
           class="form-control @if(isset($errors) && $errors->has($input->getViewId())) is-invalid @endif"
           wire:model.{{config('livewire-forms.update_mode')}}="{{ $input->getViewId() }}">
    @include('nodus.packages.livewire-forms::livewire.'.config('livewire-forms.theme').'.components.validation')
</div>
