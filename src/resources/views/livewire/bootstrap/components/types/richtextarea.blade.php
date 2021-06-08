<div class="nodus-form-control" id="{{ $input->getId(true) }}_container">
    <div wire:ignore>
        <div id="{{ $input->getId(true) }}">
            {!! $this->values[$input->getId()] !!}
        </div>
    </div>
    <textarea name="{{ $input->getId() }}"
              id="{{ $input->getId(true) }}_text"
              class="d-none"
              wire:model.defer="{{ $input->getViewId() }}"
    >{!! $this->values[$input->getId()] !!}</textarea>
    @include('nodus.packages.livewire-forms::livewire.'.config('livewire-forms.theme').'.components.hint')
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

            element.setAttribute('data-init', 'true');
        }

        @if($initialRender===true)
            document.addEventListener('livewire:load', init);
        @else
            init();
        @endif
    }());
</script>
