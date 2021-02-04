<div class="nodus-form-control" id="{{ $input->getId(true) }}_container">
    <div wire:ignore>
        <textarea id="{{ $input->getId(true) }}">{!! $this->values[$input->getId()] !!}</textarea>
    </div>
    <textarea name="{{ $input->getId() }}"
              id="{{ $input->getId(true) }}_text"
              class="d-none"
              wire:model.defer="{{ $input->getViewId() }}"
    >{!! $this->values[$input->getId()] !!}</textarea>
    @include('nodus.packages.livewire-forms::livewire.'.config('livewire-forms.theme').'.components.hint')
    @include('nodus.packages.livewire-forms::livewire.'.config('livewire-forms.theme').'.components.validation')
</div>

<script>
    (function(){
        function init() {
            const element = document.querySelector('#{{ $input->getId(true) }}');
            const input = document.querySelector('#{{ $input->getId(true) }}_text');
            const editor = CodeMirror.fromTextArea(element, {
                mode: (@json($input->getMode())),
                lineNumbers: true,
            });

            editor.on("change", function(){
                input.dispatchEvent(new CustomEvent('input',{
                    detail: editor.getValue(),
                    bubbles: true,
                }));
            })
        }

        @if($initialRender===true)
            document.addEventListener('livewire:load', init);
        @else
            init();
        @endif
    }());
</script>
