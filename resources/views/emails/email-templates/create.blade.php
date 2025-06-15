@extends('admin.index')

@section('conten')
    <div id="content-page" class="content-page">

        <div class="container-fluid">
            {{-- Kiểm tra xem biến $template có tồn tại không để biết đây là form Sửa hay Tạo mới --}}
            @if (isset($template))
                <h1>Chỉnh Sửa Mẫu Email</h1>
                <form action="{{ route('admin.email-templates.update', $template->template_id) }}" method="POST">
                    @method('PUT')
                @else
                    <h1>Tạo Mẫu Email Mới</h1>
                    <form action="{{ route('admin.email-templates.store') }}" method="POST">
            @endif

            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Tên Mẫu (để bạn nhận biết)</label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $template->name ?? '') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="subject">Tiêu Đề Email</label>
                        <input type="text" name="subject" id="subject"
                            class="form-control @error('subject') is-invalid @enderror"
                            value="{{ old('subject', $template->subject ?? '') }}" required>
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="body">Nội Dung Email</label>

                        <textarea name="body" id="body" class="form-control @error('body') is-invalid @enderror" rows="15"
                            required>{{ old('body', isset($template) ? $template->body : '') }}</textarea>
                        <small class="form-text text-muted">Sử dụng các biến: [TEN_HOI_VIEN], [NGAY_THAM_GIA]</small>
                        @error('body')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Lưu Mẫu</button>
                    <a href="{{ route('admin.email-templates.index') }}" class="btn btn-secondary">Hủy</a>
                </div>
            </div>
            </form>
        </div>
    </div>
@endsection
