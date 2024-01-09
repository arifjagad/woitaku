<!-- File: resources/views/pdf/ticket.blade.php -->

<html>
    <head>
        <style>
            /* Add your PDF styles here */
            body {
                font-family: Arial, sans-serif;
                padding: 20px;
            }

            .text-center {
                text-align: center;
            }

            .text-justify {
                text-align: justify;
            }

            .mt-4 {
                margin-top: 32px;
            }

            .ticket {
                border: 1px solid #000;
                padding: 20px;
                margin: 10px;
            }

            .event-table {
                width: 100%;
                border-collapse: collapse;
            }

            .event-table tr {
                border-bottom: 1px solid #ccc;
            }

            .event-table td {
                padding: 10px;
                text-align: left;
            }

            .event-table td:first-child {
                font-weight: bold;
                width: 35%;
            }

            .event-table td:second-child {
                width: 5%;
            }

            .event-table td:last-child {
                width: 60%;
            }
        </style>
    </head>
    <body>
        <div class="ticket">
            <h2 class="text-center">Informasi Tiket</h2>
            <h2 class="text-center">Id Tiket: #{{ $dataTicket->ticket_identifier }}</h2>
            <h4 class="mt-4">Informasi Umum</h4>
            <table class="event-table">
                <tr>
                    <td>Nama Event</td>
                    <td>:</td>
                    <td>{{ $dataTicket->event_name }}</td>
                </tr>
                <tr>
                    <td>Tanggal Event</td>
                    <td>:</td>
                    <td>{{ \Carbon\Carbon::parse($dataTicket->start_date)->format('d F Y') }} - {{ \Carbon\Carbon::parse($dataTicket->end_date)->format('d F Y') }}</td>
                </tr>
                <tr>
                    <td>Lokasi</td>
                    <td>:</td>
                    <td>{{ $dataTicket->address }}</td>
                </tr>
                <tr>
                    <td>Nama Pembeli</td>
                    <td>:</td>
                    <td>{{ $dataUser->name }}</td>
                </tr>
                <tr>
                    <td>Tanggal Pembelian</td>
                    <td>:</td>
                    <td>{{ $dataTicketBuy->created_at }}</td>
                </tr>
            </table>

            <h4 class="mt-4">Ketentuan Penggunaan Tiket</h4>
            <p class="text-justify">Tiket ini merupakan bukti pembelian tiket acara. Tiket hanya berlaku pada Hari
                <strong>{{ \Carbon\Carbon::parse($dataTicket->preferred_date)->format('l') }}</strong>,
                <strong>{{ \Carbon\Carbon::parse($dataTicket->preferred_date)->format('d F Y') }}</strong>. Tiket ini tidak akan aktif (tidak dapat
                digunakan) jika tidak sesuai dengan harinya. Pastikan menggunakan tiket ini pada
                hari yang telah Anda pilih. Tiket akan kadaluarsa setelah melewati tanggal yang
                telah dipilih.
            </p>

            <p class="text-center mt-4">Founder WOITAKU Events.</p>

        </div>
    </body>
</html>