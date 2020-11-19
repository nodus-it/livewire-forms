<div class="nodus-form-control" id="{{ $input->getId() }}_container">
    <div wire:ignore>
        <div id="{{ $input->getId() }}">
            {!! $this->values[$input->getId()] !!}
        </div>
    </div>
    <textarea name="{{ $input->getId() }}"
              id="{{ $input->getId() }}_text"
              class="d-none"
              wire:model.defer="{{ $input->getViewId() }}"
    >{!! $this->values[$input->getId()] !!}</textarea>
    @include('nodus.packages.livewire-forms::livewire.'.config('livewire-forms.theme').'.components.validation')
</div>

<script>
    (function(){
        function init() {
            const element = document.querySelector('#{{ $input->getId() }}');
            const input = document.querySelector('#{{ $input->getId() }}_text');
            const editor = new Quill(element,{
                theme: 'snow'
            });

            editor.on('text-change', function() {
                input.dispatchEvent(new CustomEvent('input',{
                    detail: editor.root.innerHTML,
                    bubbles: true,
                }));
            });

            editor.on('selection-change', function(range, oldRange, source) {
                if (( range === null && oldRange !== null) || (range === null && oldRange === undefined  )) {
                @this.set('{{ $input->getViewId() }}', editor.root.innerHTML);
                }
            });
        }

        @if($initialRender===true)
            document.addEventListener('livewire:load', init);
        @else
            init();
        @endif
    }());
</script>