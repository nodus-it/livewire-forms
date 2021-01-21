<form class="livewire-formview" wire:submit.prevent="onSubmit">
    <div class="row">
        @foreach($this->getInputs() as $input)
            @if($input->getType() == 'hidden')
                <input type="hidden" name="{{ $input->getName() }}" value="{{$input->getValue()}}">
            @elseif($input->getType() == 'section')
                <div class="col-12 mt-4"><h3>{{ $input->getLabel() }}</h3>
                    <hr/>
                </div>
            @else
                <div class="col-{{ $input->getSize() }}">
                    <label for="{{ $input->getId() }}">{{ $input->getLabel() }}</label>
                    {!! $input->render($initialRender) !!}
                </div>
            @endif
        @endforeach
    </div>
    <div class="row">
        <div class="col">
            <button type="submit" class="btn btn-primary">Speichern</button>
        </div>
    </div>
</form>
