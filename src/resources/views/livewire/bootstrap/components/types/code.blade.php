<div class="nodus-form-control" id="{{ $input->getId(true) }}_container">
    <div wire:ignore>
        <textarea class="d-none" id="{{ $input->getId(true) }}">{!! $this->values[$input->getId()] !!}</textarea>
    </div>
    <textarea name="{{ $input->getId() }}"
              id="{{ $input->getId(true) }}_text"
              class="d-none"
              wire:model.defer="{{ $input->getViewId() }}"
    >{!! $this->values[$input->getId()] !!}</textarea>
    @include('nodus.packages.livewire-forms::livewire.'.config('livewire-forms.theme').'.components.validation')
</div>

<script {!! $input->getNonceAttribute() !!}>
    (function(){
        function init() {
            const element = document.querySelector('#{{ $input->getId(true) }}');
            const input = document.querySelector('#{{ $input->getId(true) }}_text');

            if (element.hasAttribute('data-init') && element.getAttribute('data-init') === 'true') {
                console.log('Already initialized', element);
                return true;
            }

            const editor = CodeMirror.fromTextArea(element, {
                mode: (@json($input->getMode())),
                lineNumbers: true,
                indentUnit: 4,
            });

            editor.on("change", function(){
                input.dispatchEvent(new CustomEvent('input',{
                    detail: editor.getValue(),
                    bubbles: true,
                }));
            });

            editor.setOption("extraKeys", {
                Tab: function(cm) {
                    var spaces = Array(cm.getOption("indentUnit") + 1).join(" ");
                    cm.replaceSelection(spaces);
                }
            });

            element.setAttribute('data-init', 'true');
        }

        @if($initialRender===true)
            document.addEventListener('livewire:load', init);
        @else
            init();
        @endif
    }());
</script>
