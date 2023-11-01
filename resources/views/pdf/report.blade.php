<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sales report</title>
    <style>
        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .header,
        .footer,
        .table-items {
            width: 100%;
        }

        .header img {
            width: 100%;
            max-width: 100px;
        }

        .table-items th,
        .table-items td {
            text-align: center;
        }

        .text-company {
            font-size: 16px;
        }
    </style>
</head>

<body>
    <section class="header" style="margin-top: -20px;">
        <table class="header">
            <tr>
                <td colspan="2" class="text-center" style="font-size: 25px; font-weight: bold;">POS System</td>
            </tr>
            <tr>
                <td width="30%">
                    <img src="{{ public_path('assets/img/livewire_logo.png') }}" alt="Invoice Logo"
                        class="invoice-logo">
                </td>
                <td width="70%" class="text-left text-company">
                    @if ($reportType == 0)
                        <strong>Today's Sales Report</strong>
                    @else
                        <strong>Report by Date</strong>
                    @endif
                    <br>
                    @if ($reportType != 0)
                        <strong>Consult date: {{ $dateFrom }} to {{ $dateTo }}</strong>
                    @else
                        <strong>Consult date: {{ \Carbon\Carbon::now()->format('d-m-Y') }}</strong>
                    @endif
                    <br>
                    User: {{ $user }}
                </td>
            </tr>
        </table>
    </section>

    <section style="margin-top: 10px;">
        <table class="table-items">
            <thead>
                <tr>
                    <th width="10%">Invoice</th>
                    <th width="12%">Import</th>
                    <th width="10%">Items</th>
                    <th width="12%">Status</th>
                    <th>User</th>
                    <th width="18%">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ number_format($item->total, 2) }}</td>
                        <td>{{ $item->items }}</td>
                        <td>{{ $item->status }}</td>
                        <td>{{ $item->user }}</td>
                        <td>{{ $item->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td><b>Total</b></td>
                    <td><strong>{{ number_format($data->sum('total'), 2) }}</strong></td>
                    <td>{{ $data->sum('items') }}</td>
                    <td colspan="3"></td>
                </tr>
            </tfoot>
        </table>
    </section>

    <section class="footer" style="margin-top: 10px;">
        <table class="table-items">
            <tr>
                <td width="20%">POS System v1</td>
                <td width="60%" class="text-center">nesgc.com</td>
                <td width="20%" class="text-center">Page <span class="pagenum"></span></td>
            </tr>
        </table>
    </section>
</body>

</html>
