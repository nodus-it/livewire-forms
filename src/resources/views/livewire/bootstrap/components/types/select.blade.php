<div class="nodus-form-control" id="{{ $input->getId() }}_container" wire:ignore>
    <select name="{{ $input->getName() }}"
            class="form-control selectpicker @if($errors->has($input->getViewId())) is-invalid @endif"
            @if($input->getMultiple()) multiple @endif
            data-size="10"
            data-live-search="true"
            data-deselect-all-text="{{ $input->getDeselectAllText() }}"
            data-select-all-text="{{ $input->getSelectAllText() }}"
            data-none-selected-text="{{ $input->getNoneSelectedText() }}"
            data-none-results-text="{{ $input->getNoneResultsText() }}"
            wire:model="{{ $input->getViewId() }}">
        @foreach($input->getValues() as $key => $option)
            <option value="{{ $key }}" data-icon="{{ $option['icon'] }}">{{ $option['label'] }}</option>
        @endforeach
    </select>
    @include('nodus.packages.livewire-forms::livewire.'.config('livewire-forms.theme').'.components.validation')
</div>
