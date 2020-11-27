<div class="nodus-form-control" id="{{ $input->getId() }}_container">
    <textarea name="{{ $input->getName() }}"
              @if($input->hasPlaceholder()) placeholder="{{ $input->getPlaceholder() }}" @endif
              class="form-control @if($errors->has($input->getViewId())) is-invalid @endif"
              wire:model.{{config('livewire-forms.update_mode')}}="{{ $input->getViewId() }}">
    </textarea>
    @include('nodus.packages.livewire-forms::livewire.'.config('livewire-forms.theme').'.components.hint')
    @include('nodus.packages.livewire-forms::livewire.'.config('livewire-forms.theme').'.components.validation')
</div>
