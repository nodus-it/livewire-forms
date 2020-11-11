<div class="nodus-form-control" wire:ignore>
    <div id="{{ $input->getId() }}">
        {!! $this->values[$input->getId()] !!}
    </div>
    <input type="hidden"
           value="{!! $this->values[$input->getId()] !!}"
           name="{{ $input->getId() }}"
           id="{{ $input->getId() }}_text"
           wire:model.defer="{{ $input->getViewId() }}"
    >
    @include('nodus.packages.livewire-forms::livewire.'.config('livewire-forms.theme').'.components.validation')
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
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
    });
</script>

