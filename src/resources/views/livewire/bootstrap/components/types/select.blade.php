<div class="nodus-form-control nodus-form-control-select" id="{{ $input->getId(true) }}_container" data-id="{{ $input->getId(true) }}">
    <div>
        <select name="{{ $input->getName() }}"
                id="{{ $input->getId(true) }}"
                class="form-control selectpicker @if(isset($errors) && $errors->hasAny($input->getErrorKeys())) is-invalid @endif"
                @if($input->getMultiple()) multiple @endif
                data-size="10"
                data-live-search="true"
                data-deselect-all-text="{{ $input->getDeselectAllText() }}"
                data-select-all-text="{{ $input->getSelectAllText() }}"
                data-none-selected-text="{{ $input->getNoneSelectedText() }}"
                data-none-results-text="{{ $input->getNoneResultsText() }}"
                @if($input::supports('disabling') && $input->isDisabled()) disabled @endif
                wire:model.{{config('livewire-forms.update_mode')}}="{{ $input->getViewId() }}">
            @foreach($input->getOptions() as $key => $option)
                <option value="{{ $key }}" data-icon="{{ $option['icon'] }}">{{ $option['label'] }}</option>
            @endforeach
        </select>
    </div>
    @include('nodus.packages.livewire-forms::livewire.'.config('livewire-forms.theme').'.components.validation')
</div>
