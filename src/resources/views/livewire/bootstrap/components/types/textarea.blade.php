<div class="nodus-form-control nodus-form-control-textarea" id="{{ $input->getId(true) }}_container" data-id="{{ $input->getId(true) }}">
    <textarea name="{{ $input->getName() }}"
              @if($input->hasPlaceholder()) placeholder="{{ $input->getPlaceholder() }}" @endif
              class="form-control @if(isset($errors) && $errors->has($input->getViewId())) is-invalid @endif"
              wire:model.{{config('livewire-forms.update_mode')}}="{{ $input->getViewId() }}">
    </textarea>
    @include('nodus.packages.livewire-forms::livewire.'.config('livewire-forms.theme').'.components.validation')
</div>
