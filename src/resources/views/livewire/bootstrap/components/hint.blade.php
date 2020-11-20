@if(method_exists($input,'getHint') && $input->getHint() != null)
    <span class="nodus-hint text-muted">{{$input->getHint()}}</span>
@endif
