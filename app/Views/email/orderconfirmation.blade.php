@extends($layout)



@section("content")
    <h2>Hallo, {{ $order['recipient'] }}!</h2>

    <p>Wir haben Deine Bestellung erhalten!</p>

    <h3>Lieferadresse</h3>
    <table>
        <tbody>
            <tr>
                <th tyle="text-align:left;">Empfänger</th>
                <td>{{ $order['recipient'] }}</td>
            </tr>
            <tr>
                <th style="text-align:left;">Straße / Hausnummer</th>
                <td>{{ $order['address_line_1'] }}</td>
            </tr>
            <tr>
                <th style="text-align:left;">Adresszusatz</th>
                <td>{{ $order['address_line_2'] }}</td>
            </tr>
            <tr>
                <th style="text-align:left;">PLZ / Ort</th>
                <td>{{ $order['postal_code'] }} {{ $order['city'] }}</td>
            </tr>
            <tr>
                <th style="text-align:left;">Land</th>
                <td>{{ $order['country'] }}</td>
            </tr>
        </tbody>
    </table>
  
    <br>
    <h3>Bestellung</h3>
    <br>

    <x-orderitemlist
        :orderedItems="$items"
        :totalSum="$totalSum"
        :taxPot="$taxPot"
        :root="rtrim($opt['application_root'], '/') . '/'"
        :cartIndex="false"
    />
    <br>
    <p>Vielen Dank!</p>
    <p>Wir melden uns, sobald es weiter geht.</p>




@endsection
