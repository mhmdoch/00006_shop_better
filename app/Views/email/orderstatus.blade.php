@extends($layout)

@section("content")
    <h2>Hallo, {{ $order['recipient'] }}!</h2>

    <p>Der Status deiner Bestellung
        {{ $order['order_number'] }} wurde geändert.</p>

    <p>Neuer Status: <strong>{{ $status }}</strong></p>
@endsection
