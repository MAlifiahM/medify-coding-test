<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

<script>
    var start_date = '';
    var end_date = '';
    var data_per_fetch = 500;
    var data_fetched = 0;

    $(document).ready(function() {
        $('#table').DataTable({
            searching: false,
            order: [[0, 'desc']],
        });
        getData()
    });

    $('.btn-get-data').click(function() {
        getData()
    })

    function getData(){
        
        // $('#loading-filter').show();
        var dataTableObj = $('#table').DataTable();
        // var filter_kode = $('#filter-kode').val()
        // var filter_nama = $('#filter-nama').val()
        // var filter_harga_min = $('#filter-harga-min').val()
        // var filter_harga_max = $('#filter-harga-max').val()
        dataTableObj.clear().draw();

        $.ajax({
            url: '{{url("kategori/search")}}',
            dataType: 'json',
            tryCount: 0,
            retryLimit: 3,

            success: function(results) {
                var data = results.data

                $.each(data, function(index, item) {
                    var array_temp = [];

                    var kode = item.kode;
                    var nama = item.name;

                    var html = `<a href="{{ url('kategori/view/') }}/${item.id}"
                                class="btn btn-primary">View</a>`;

                    array_temp.push(kode);
                    array_temp.push(nama);
                    array_temp.push(html);

                    dataTableObj.row.add(array_temp).draw(false);
                });
                $('#loading-filter').hide();
            },
            error: function(xhr, textStatus, errorThrown) {
                this.tryCount++;
                if (this.tryCount <= this.retryLimit) {
                    $.ajax(this);
                    return;
                }
                alert('Terjadi kesalahan server, tidak dapat mengambil data')
                $('#loading-filter').hide();

                return;
            }
        })
    }
</script>