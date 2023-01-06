<div class="nodus-form-control nodus-form-control-checkbox" id="{{ $input->getId(true) }}_container" data-id="{{ $input->getId(true) }}">
    <div class="custom-control custom-switch">
        <input type="checkbox"
               name="{{ $input->getName() }}"
               class="custom-control-input"
               id="{{ $input->getId(true) }}"
               wire:model.{{config('livewire-forms.update_mode')}}="{{ $input->getViewId() }}">
        <label class="custom-control-label nodus-form-label-right" for="{{ $input->getId(true) }}">
            @if($input->getLabelMode() === 'right')
                @if($input->hasHtmlLabel())
                    {!! $input->getLabel() !!}
                @else
                    {{ $input->getLabel() }}
                @endif
            @endif
        </label>
    </div>
    @include('nodus.packages.livewire-forms::livewire.'.config('livewire-forms.theme').'.components.validation')
</div>
