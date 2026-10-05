@extends($layout)

@section("content")

Thumb:
<image src="<?= $opt['root'] ?>uploads/thumb_6ac35e7bbe6e3.jpg" ><br>
Original:
<image src="<?= $opt['root'] ?>uploads/6ac35e7bbe6e3.jpg" >

<script>
    setInterval(() => {
        location.reload();
    }, 3000);
</script>

@endsection
