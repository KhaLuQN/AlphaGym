@extends('admin.index')

@section('conten')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <h1>Chi Tiết Email Đã Gửi</h1>
            <div class="card">
                <div class="card-header">
                    <h4>{{ $log->subject }}</h4>
                </div>
                <div class="card-body">
                    <p><strong>Người nhận:</strong> {{ $log->member->full_name ?? '[Đã xóa]' }}
                        ({{ $log->member->email ?? 'N/A' }})</p>
                    <p><strong>Người gửi:</strong> {{ $log->sender->full_name ?? 'Hệ thống' }}</p>
                    <p><strong>Tên chiến dịch:</strong> {{ $log->campaign_name }}</p>
                    <p><strong>Thời gian gửi:</strong> {{ \Carbon\Carbon::parse($log->sent_at)->format('H:i:s d/m/Y') }}</p>
                    <p><strong>Trạng thái:</strong> {{ $log->status == 'sent' ? 'Thành công' : 'Thất bại' }}</p>
                    <hr>
                    <h5>Nội dung email:</h5>
                    <div class="p-3 border rounded bg-light">
                        {{-- Dùng {!! !!} để render HTML từ CKEditor --}}
                        {!! $log->body !!}
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.communication-logs.index') }}" class="btn btn-secondary">Quay lại Danh sách</a>
                </div>
            </div>
        </div>
    </div>
@endsection
