<div class="nodus-form-control" id="{{ $input->getId() }}_container">
    <div wire:ignore>
        <textarea id="{{ $input->getId() }}">
            {!! $this->values[$input->getId()] !!}
        </textarea>
    </div>
    <textarea name="{{ $input->getId() }}"
              id="{{ $input->getId() }}_text"
              class="d-none"
              wire:model.lazy="{{ $input->getViewId() }}"
    >{!! $this->values[$input->getId()] !!}</textarea>
    @include('nodus.packages.livewire-forms::livewire.'.config('livewire-forms.theme').'.components.hint')
    @include('nodus.packages.livewire-forms::livewire.'.config('livewire-forms.theme').'.components.validation')
</div>

<script>
    (function(){
        function init() {
            const element = document.querySelector('#{{ $input->getId() }}');
            const input = document.querySelector('#{{ $input->getId() }}_text');

            const view = CodeMirror.fromTextArea(element, {
                mode: (@json($input->getMode())),
                lineNumbers: true,
            });

            view.on("change", function(){
                input.dispatchEvent(new CustomEvent('input',{
                    detail: view.getValue(),
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
