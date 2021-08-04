<div class="nodus-form-control" id="{{ $input->getId(true) }}_container" >
    <div wire:ignore>
        <select name="{{ $input->getName() }}"
                class="form-control selectpicker @if(isset($errors) && $errors->has($input->getViewId())) is-invalid @endif"
                @if($input->getMultiple()) multiple @endif
                data-size="10"
                data-live-search="true"
                data-deselect-all-text="{{ $input->getDeselectAllText() }}"
                data-select-all-text="{{ $input->getSelectAllText() }}"
                data-none-selected-text="{{ $input->getNoneSelectedText() }}"
                data-none-results-text="{{ $input->getNoneResultsText() }}"
                wire:model="{{ $input->getViewId() }}">
            @foreach($input->getOptions() as $key => $option)
                <option value="{{ $key }}" data-icon="{{ $option['icon'] }}">{{ $option['label'] }}</option>
            @endforeach
        </select>
    </div>
    @include('nodus.packages.livewire-forms::livewire.'.config('livewire-forms.theme').'.components.validation')
</div>

{{-- Todo improve JS handling in order to support dynamic options and improve validation state visibility --}}
{{-- @see https://github.com/livewire/livewire/issues/45#issuecomment-520155799 --}}
<script {!! $input->getNonceAttribute() !!}>
    (function(){
        function init() {
            if (/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) {
                $('#{{ $input->getId(true) }}_container').find('.selectpicker').selectpicker('mobile');
            } else {
                $('#{{ $input->getId(true) }}_container').find('.selectpicker').selectpicker();
            }
        }

        @if($initialRender===true)
            document.addEventListener('livewire:load', init);
        @else
            init();
        @endif
    }());
</script>
