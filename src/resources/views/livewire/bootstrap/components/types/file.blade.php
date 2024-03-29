<div class="nodus-form-control nodus-form-control-file" id="{{ $input->getId(true) }}_container" data-id="{{ $input->getId(true) }}">
    <input type="{{$input->getType()}}"
           name="{{ $input->getName() }}"
           @if($input->getMultiple()) multiple @endif
           @if($input->getAcceptFormats() !== null) accept="{{ $input->getAcceptFormats() }}"  @endif
           @if($input::supports('placeholder') && $input->hasPlaceholder()) placeholder="{{ $input->getPlaceholder() }}" @endif
           @if($input::supports('disabling') && $input->isDisabled()) disabled @endif
           class="form-control @if(isset($errors) && $errors->hasAny($input->getErrorKeys())) is-invalid @endif"
           wire:model.{{config('livewire-forms.update_mode')}}="{{ $input->getViewId() }}">
    @include('nodus.packages.livewire-forms::livewire.'.config('livewire-forms.theme').'.components.validation')
</div>
