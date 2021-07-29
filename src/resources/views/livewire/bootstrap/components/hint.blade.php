@if(method_exists($input,'getHint') && $input->getHint() != null)
    <span class="nodus-hint text-info" data-toggle="tooltip" data-placement="right" title="{{$input->getHint()}}">
        🛈
    </span>
@endif
