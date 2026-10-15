@extends($layout)

@section("content")


<div class="row">
    <main class="col-lg-12">
            <div class="bg-box rounded p-4 mb-4">
                <div id="create_reportbook"></div>
            </div>
        </div>
    </main>
</div>


    <script>
        $(document).ready(function() {

            var catalog_create_form = Z.Forms.create({
                dom: "create_reportbook"
            });
            catalog_create_form.createField({
                name: "name",
                type: "text",
                text: "Schüler/Name",
                value: "Patrick Müller",
                required: true
            });
            catalog_create_form.createField({
                name: "provider",
                type: "text",
                text: "Ausbildungsabteilung",
                value: "COMCAVE.COLLEGE Dortmund",
                required: true
            });
            catalog_create_form.createField({
                name: "reportnumber",
                type: "text",
                text: "Berichtsheftnummer",
                required: true
            });
            catalog_create_form.createField({
                name: "weekstart",
                type: "text",
                text: "Woche vom",
                width: 6,
                required: true
            });
            catalog_create_form.createField({
                name: "weekend",
                type: "text",
                text: "bis",
                width: 6,
                required: true
            });
            catalog_create_form.createField({
                name: "year",
                type: "text",
                text: "Ausbildungsjahr",
                value: <?= date('Y') ?>,
                attributes: { 'data-test': 'year'},
                required: true
            });

            <?php foreach(["Montag", "Di", "Mi", "Do", "Fr"] as $i => $day) { ?>
                catalog_create_form.createField({
                    name: "day{{ $i + 1 }}",
                    type: "textarea",
                    text: "{{ $day }}",
                    width: 11,
                    attributes: { rows: 4 },
                    value: {!! json_encode($costReport[$i + 1]["comments"] ?? "") !!}
                });
                catalog_create_form.createField({
                    name: "day{{ $i + 1 }}hours",
                    type: "text",
                    text: "Stunden",
                    width: 1,
                    value: "{{ $costReport[$i + 1]["hours"] ?? 0 }}"
                });
            <?php } ?>

            catalog_create_form.buttonSubmit.innerHTML = "Speichern";
            catalog_create_form.saveHook = (res) => {
                catalog_create_form.reset();
            };

            $('[data-test="year"]').after('<br><hr>');

        });
    </script>

@endsection


