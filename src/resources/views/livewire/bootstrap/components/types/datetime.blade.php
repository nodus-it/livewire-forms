<div class="nodus-form-control">
    <div class="input-group">
        <input type="date"
               name="{{ $input->getName() }}_date"
               class="form-control @if($errors->has($input->getViewId())) is-invalid @endif"
               wire:model.{{config('livewire-forms.update_mode')}}="{{ $input->getViewId() }}_date">
        <input type="time"
               name="{{ $input->getName() }}_time"
               class="form-control @if($errors->has($input->getViewId())) is-invalid @endif"
               wire:model.{{config('livewire-forms.update_mode')}}="{{ $input->getViewId() }}_time">
    </div>
    @include('nodus.packages.livewire-forms::livewire.'.config('livewire-forms.theme').'.components.hint')
    @include('nodus.packages.livewire-forms::livewire.'.config('livewire-forms.theme').'.components.validation')
</div>
