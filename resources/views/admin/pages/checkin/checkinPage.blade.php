@extends('admin.index')

@section('conten')
    <div id="content-page" class="content-page">
        <div class="container text-center mt-5">
            <h2 class="mb-4">QUÉT THẺ ĐỂ CHECK-IN</h2>

            <form id="checkinForm" action="{{ route('admin.checkin.machine') }}" method="POST">
                @csrf
                <input type="text" id="rfidInput" name="rfid_card_id" autocomplete="off" autofocus
                    style="opacity:0; position:absolute;">
            </form>

            <p class="text-muted mt-3">Vui lòng quét thẻ tại máy để thực hiện check-in.</p>

            @if (session('message'))
                <div class="alert alert-info mt-4">
                    {{ session('message') }}
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('rfidInput');

            input.focus();

            input.addEventListener('change', function() {
                document.getElementById('checkinForm').submit();
            });

            setInterval(() => {
                if (document.activeElement !== input) {
                    input.focus();
                }
            }, 1000);
        });
    </script>
@endsection
