<div class="nodus-form-control nodus-form-control-richtextarea" id="{{ $input->getId(true) }}_container" data-id="{{ $input->getId(true) }}">
    <div wire:ignore>
        <div id="{{ $input->getId(true) }}">
            {!! $this->values[$input->getId()] !!}
        </div>
    </div>
    <textarea name="{{ $input->getId() }}"
              id="{{ $input->getId(true) }}_text"
              class="d-none"
              wire:model.defer="{{ $input->getViewId() }}"
    >{!! $this->values[$input->getId()] !!}</textarea>
    @include('nodus.packages.livewire-forms::livewire.'.config('livewire-forms.theme').'.components.validation')
</div>
