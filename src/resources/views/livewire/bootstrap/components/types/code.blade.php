<div class="nodus-form-control nodus-form-control-code"
     id="{{ $input->getId(true) }}_container"
     data-id="{{ $input->getId(true) }}"
     data-mode="{{ $input->getMode() }}">
    <div wire:ignore class="nodus-form-container-static">
        <textarea class="d-none" id="{{ $input->getId(true) }}">{!! $this->getValue($input->getId()) !!}</textarea>
    </div>
    <textarea name="{{ $input->getId() }}"
              id="{{ $input->getId(true) }}_text"
              class="d-none"
              wire:model.defer="{{ $input->getViewId() }}"
    >{!! $this->getValue($input->getId()) !!}</textarea>
    @include('nodus.packages.livewire-forms::livewire.'.config('livewire-forms.theme').'.components.validation')
</div>
