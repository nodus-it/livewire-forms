<div class="nodus-form-control" wire:ignore>
    <select name="{{ $input->getName() }}"
            class="form-control selectpicker @if($errors->has($input->getViewId())) is-invalid @endif"
            @if($input->getMultiple()) multiple @endif
            wire:model="{{ $input->getViewId() }}">
        @foreach($input->getValues() as $key => $option)
            <option value="{{ $key }}" data-icon="{{ $option['icon'] }}">{{ $option['label'] }}</option>
        @endforeach
    </select>
    @include('nodus.packages.livewire-forms::livewire.'.config('livewire-forms.theme').'.components.validation')
</div>
