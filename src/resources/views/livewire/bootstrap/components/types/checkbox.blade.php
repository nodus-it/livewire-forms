<div class="nodus-form-control" id="{{ $input->getId(true) }}_container">
    <div class="custom-control custom-switch">
        <input type="checkbox"
               name="{{ $input->getName() }}"
               class="custom-control-input"
               id="{{ $input->getId(true) }}"
               wire:model.{{config('livewire-forms.update_mode')}}="{{ $input->getViewId() }}">
        <label class="custom-control-label" for="{{ $input->getId(true) }}"></label>
    </div>
    @include('nodus.packages.livewire-forms::livewire.'.config('livewire-forms.theme').'.components.hint')
    @include('nodus.packages.livewire-forms::livewire.'.config('livewire-forms.theme').'.components.validation')
</div>
