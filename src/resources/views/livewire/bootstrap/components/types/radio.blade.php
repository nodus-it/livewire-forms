<div class="nodus-form-control" id="{{ $input->getId(true) }}_container" >
    <div class="btn-group btn-group-toggle flex-wrap" data-toggle="buttons">
        @foreach($input->getOptions() as $key => $option)
            <label class="btn btn-primary @if($this->values[$input->getId()] === $key) active @endif">
                <input type="radio"
                       class="btn-check"
                       name="start"
                       value="{{$key}}"
                       wire:model="{{ $input->getViewId() }}"
                       autocomplete="off" >
                {{$option['label']}}
            </label>
        @endforeach
    </div>

    @include('nodus.packages.livewire-forms::livewire.'.config('livewire-forms.theme').'.components.hint')
    @include('nodus.packages.livewire-forms::livewire.'.config('livewire-forms.theme').'.components.validation')
</div>
