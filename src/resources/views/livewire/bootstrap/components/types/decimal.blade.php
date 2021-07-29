<div class="nodus-form-control" id="{{ $input->getId(true) }}_container">
    <input type="text"
           id="{{ $input->getId(true) }}"
           name="{{ $input->getName() }}"
           class="form-control @if(isset($errors) && $errors->has($input->getViewId())) is-invalid @endif"
           wire:model.lazy="{{ $input->getViewId() }}"
           data-decimals="{{ $input->getDecimals() }}"
           data-unit="{{ $input->getUnit() }}"
    >
    @include('nodus.packages.livewire-forms::livewire.'.config('livewire-forms.theme').'.components.validation')
</div>

@push(config('livewire-forms.view_stack_js'))
    <script {!! $input->getNonceAttribute() !!}>
        new Nodus.DecimalInput('#{{ $input->getId(true) }}')
    </script>
@endpush
