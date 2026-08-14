@props(["type" => "info"])

@if($product == "orange")
<div class="card mb-2">
    <div class="card-body">
        {{ $slot }}
    </div>
</div>
@else
<div class="alert alert-{{ $type }}">
    {{ $type }}:
    {{ $slot }}
</div>
@endif