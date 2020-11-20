@if(method_exists($input,'getHint') && $input->getHint() != null)
    <span class="feedback text-muted">&nbsp;{{$input->getHint()}}</span>
@endif
