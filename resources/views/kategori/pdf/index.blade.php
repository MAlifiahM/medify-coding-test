
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Data Kategori</title>

    <style>
        @page {
            margin: 30px 30px 60px 30px;
        }

        body {
            font-family: sans-serif;
            font-size: 11px;
            color: #333;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        h4 {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .detail td {
            padding: 5px;
        }

        .detail th {
            width: 100px;
            text-align: left;
        }

        .items th,
        .items td {
            border: 1px solid #999;
            padding: 7px;
        }

        .items th {
            background-color: #eee;
            text-align: center;
        }

        .items td {
            vertical-align: middle;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            position: fixed;
            bottom: -35px;
            left: 0;
            right: 0;
            border-top: 1px solid #999;
            padding-top: 8px;
            font-size: 9px;
            text-align: center;
        }
    </style>
</head>

<body>

    <h2>DATA MASTER KATEGORI</h2>

    <h4>Informasi Kategori</h4>

    <table class="detail">
        <tr>
            <th>Nama</th>
            <td>:</td>
            <td>{{ $data->name }}</td>
        </tr>
        <tr>
            <th>Kode</th>
            <td>:</td>
            <td>{{ $data->kode }}</td>
        </tr>
    </table>

    <br>

    <h4>Data Master Item</h4>

    <table class="items">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Harga Beli</th>
                <th>Laba</th>
                <th>Harga Jual</th>
                <th>Supplier</th>
                <th>Jenis</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($data->items as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $item->kode }}</td>
                    <td>{{ $item->nama }}</td>
                    <td class="text-right">
                        Rp {{ number_format($item->harga_beli, 0, ',', '.') }}
                    </td>
                    <td class="text-center">{{ $item->laba }}%</td>
                    <td class="text-right">
                        Rp {{ number_format($item->harga_beli + ($item->harga_beli * $item->laba / 100), 0, ',', '.') }}
                    </td>
                    <td>{{ $item->supplier }}</td>
                    <td>{{ $item->jenis }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">
                        Data not available
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d-m-Y H:i:s') }}
    </div>

</body>
</html>
