<div class="nodus-form-control" id="{{ $input->getId() }}_container">
    <input type="text"
           id="{{ $input->getId() }}"
           name="{{ $input->getName() }}"
           class="form-control @if(isset($errors) && $errors->has($input->getViewId())) is-invalid @endif"
           wire:model.lazy="{{ $input->getViewId() }}"
           data-decimals="{{ $input->getDecimals() }}"
           data-unit="{{ $input->getUnit() }}"
    >
    @include('nodus.packages.livewire-forms::livewire.'.config('livewire-forms.theme').'.components.hint')
    @include('nodus.packages.livewire-forms::livewire.'.config('livewire-forms.theme').'.components.validation')
</div>

@push('javascript')
    <script>
        new Nodus.DecimalInput('#{{ $input->getId() }}')
    </script>
@endpush
