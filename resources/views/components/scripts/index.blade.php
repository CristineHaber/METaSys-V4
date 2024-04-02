<script>
    $(document).ready(function() {
        $('#judges-table').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                extend: 'print',
                text: 'Print',
                exportOptions: {
                    columns: [0, 1, 2],
                },
                customize: function(win) {
                    $(win.document.body).css('orientation', 'landscape');

                    var header = $('<div class="text-center"></div>');

                    var imgSrc = '{{ asset('images/logos/logo.jpg') }}';

                    var imgElement = $('<img/>', {
                        src: imgSrc,
                        alt: 'Logo',
                        class: 'logo',
                        width: 40,
                    });

                    header.append(imgElement);

                    header.append(
                        '<h5 style="font-family: Century Gothic;">METASYS 4.0</h5>'
                    );
                    header.append(
                        '<span style="font-family: Century Gothic;">Junior Philippine Computer Society - CSPC Chapter</span>'
                    );
                    header.append(
                        '<h3 style="font-family: Century Gothic; text-transform: uppercase;">{{ $event->event_name }}</h3>'
                    );
                    header.append(
                        '<h5 style="font-family: Century Gothic;">Judges</h5>'
                    );

                    $(win.document.body).prepend(header);

                    $(win.document.body).find('table').addClass('report-table');
                },
            }, ],
        });
    });

    $(document).ready(function() {
        $('#candidates-table').DataTable();
    });

    $(document).ready(function() {
        $('#segments-table').DataTable();
    });

    $(document).ready(function() {
        $('#finalists-table').DataTable();
    });

    $(document).ready(function() {
        $('#results-table').DataTable();
    });
</script>
