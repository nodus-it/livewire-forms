<div class="nodus-form-control" id="{{ $input->getId(true) }}_container">
    <input type="{{$input->getType()}}"
           name="{{ $input->getName() }}"
           @if($input::supports('placeholder') && $input->hasPlaceholder()) placeholder="{{ $input->getPlaceholder() }}" @endif
           class="form-control @if(isset($errors) && $errors->has($input->getViewId())) is-invalid @endif"
           wire:model.{{config('livewire-forms.update_mode')}}="{{ $input->getViewId() }}">
    @include('nodus.packages.livewire-forms::livewire.'.config('livewire-forms.theme').'.components.hint')
    @include('nodus.packages.livewire-forms::livewire.'.config('livewire-forms.theme').'.components.validation')
</div>
