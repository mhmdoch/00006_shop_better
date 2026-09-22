@extends($layout)

@section("content")
    <div class="bg-box rounded p-4">
        <h1 class="h3 mb-0">Warenkorb</h1>
    </div>

    <div id="cartNotification" class="alert alert-danger d-none mt-4" role="alert"></div>

    <?php if (empty($opt["cartItems"])): ?>
        <div class="bg-box rounded p-4 mt-4">
            Dein Warenkorb ist leer.
        </div>
    <?php else: ?>
        

    <x-orderitemlist :orderedItems="$opt['cartItems']" :totalSum="$opt['totalSum']" :taxPot="$opt['taxPot']" :root="$opt['root']" :cartIndex="true"/>



        <script>
    $(document).ready(function() {
        $(".cartItemList").on("click", ".delete-cartItem", function(event) {
            event.preventDefault();

            var id = $(this).data("id");

            Z.Request.action('delete-cartItem', {
                cartItemId: id
            }, (res) => {
                if (res.result == 'success') {
                    location.reload();
                    return;
                }
                alert("An error occurred");
            });
        });


        $(".cartItemList").on("click", ".raise-cartItem", function(event) {
            event.preventDefault();

            var id = $(this).data("id");

            Z.Request.action('raise-cartItem', {
                cartItemId: id
            }, (res) => {
                if (res.result == 'success') {
                    if (res.notificationShow) {
                        $("#cartNotification").text(res.notificationMSG).removeClass("d-none");
                        return;
                    }
                    location.reload();
                    return;
                }
                alert(JSON.stringify(res.message.message) || "An error occurred");
            });
        });

        $(".cartItemList").on("click", ".reduce-cartItem", function(event) {
            event.preventDefault();

            var id = $(this).data("id");

            Z.Request.action('reduce-cartItem', {
                cartItemId: id
            }, (res) => {
                if (res.result == 'success') {
                    location.reload();
                    return;
                }
                alert("An error occurred");
            });
        });
    });
</script>

    <?php endif; ?>
@endsection
