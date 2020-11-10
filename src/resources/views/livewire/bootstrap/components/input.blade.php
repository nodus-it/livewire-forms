<div class="nodus-form-control">
    <input type="{{$input->getType()}}"
           name="{{ $input->getName() }}"
           class="form-control @if($errors->has($input->getViewId())) is-invalid @endif"
           wire:model.{{config('livewire-forms.update_mode')}}="{{ $input->getViewId() }}">
    @include('nodus.packages.livewire-forms::livewire.'.config('livewire-forms.theme').'.components.validation')
</div>
