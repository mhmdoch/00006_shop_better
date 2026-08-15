@props(["title" => "bin ich blade?"])

@foreach(str_split($title) as $letter)
    <p>{{ $letter }}</p>
@endforeach
