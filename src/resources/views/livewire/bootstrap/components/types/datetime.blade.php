<div class="nodus-form-control">
    <div class="input-group">
        <input type="date"
               name="{{ $input->getName() }}_date"
               class="form-control @if(isset($errors) && $errors->has($input->getViewId())) is-invalid @endif"
               wire:model.{{config('livewire-forms.update_mode')}}="{{ $input->getViewId() }}.date">
        <input type="time"
               name="{{ $input->getName() }}_time"
               class="form-control @if(isset($errors) && $errors->has($input->getViewId())) is-invalid @endif"
               wire:model.{{config('livewire-forms.update_mode')}}="{{ $input->getViewId() }}.time">
    </div>
    @include('nodus.packages.livewire-forms::livewire.'.config('livewire-forms.theme').'.components.hint')
    @include('nodus.packages.livewire-forms::livewire.'.config('livewire-forms.theme').'.components.validation')
</div>
