<form class="livewire-formview" id="{{$this->getFormId()}}" wire:submit.prevent="onSubmit">
    <div class="row">
        @foreach($this->getInputs() as $input)
            @if($input->getType() == 'hidden')
                <input type="hidden" name="{{ $input->getName() }}" value="{{$input->getValue()}}">
            @elseif($input->getType() == 'html')
                <div class="col-sm-{{ $input->getSize() }}">
                    <div id="{{ $input->getId(true) }}">
                        {!! $input->getLabel() !!}
                    </div>
                </div>
            @else
                <div class="col-sm-{{ $input->getSize() }}">
                    <label for="{{ $input->getId() }}">{{ $input->getLabel() }}</label>
                    @include('nodus.packages.livewire-forms::livewire.'.config('livewire-forms.theme').'.components.hint')
                    {!! $input->render($initialRender) !!}
                </div>
            @endif
        @endforeach
    </div>
    <div class="row">
        <div class="col">
            @include('nodus.packages.livewire-forms::livewire.'.config('livewire-forms.theme').'.components.save_button')
        </div>
    </div>
</form>

@push(config('livewire-core.blade_stacks.scripts'))
    <script @nonce>
        new Nodus.FormView('#{{$this->getFormId()}}').init();
    </script>
@endpush