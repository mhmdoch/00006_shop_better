@extends($layout)

@section("content")
    <div class="bg-box rounded p-4">
        <h1 class="h3 mb-0">Warenkorb</h1>
    </div>

    <div id="cartNotification" class="alert alert-danger <?= empty($opt["discountMessage"]) ? "d-none" : "" ?> mt-4" role="alert"><?= e($opt["discountMessage"] ?? "") ?></div>

    <?php if (empty($opt["cartItems"])): ?>
        <div class="bg-box rounded p-4 mt-4">
            Dein Warenkorb ist leer.
        </div>
    <?php else: ?>
        

    <x-orderitemlist :orderedItems="$opt['cartItems']" :totalSum="$opt['totalSum']" :taxPot="$opt['taxPot']" :root="$opt['root']" :cartIndex="true" :subtotal="$opt['subtotal']" :discountAmount="$opt['discountAmount']" :discountCode="$opt['discountCode']"/>



<script>
    $(document).ready(function() {
        function applyDiscount() {
            Z.Request.action('apply-discount', {
                code: document.getElementById("discountCode").value
            }, (res) => {
                if (res.result == 'success') {
                    location.reload();
                    return;
                }
                $("#cartNotification").text(res.message || "Rabattcode konnte nicht eingelöst werden.").removeClass("d-none");
            });
        }

        $("#applyDiscount").click(applyDiscount);
        $("#discountCode").keyup(function(event) {
            if (event.keyCode == 13) applyDiscount();
        });

        $("#removeDiscount").click(function() {
            Z.Request.action('remove-discount', {}, (res) => {
                if (res.result == 'success') {
                    location.reload();
                    return;
                }
                $("#cartNotification").text("Rabattcode konnte nicht entfernt werden.").removeClass("d-none");
            });
        });

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
