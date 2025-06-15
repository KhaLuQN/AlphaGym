@extends('admin.index')
@section('conten')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <h1>Quản Lý Mẫu Email</h1>
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('admin.email-templates.create') }}" class="btn btn-primary">Tạo Mẫu Mới</a>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tên Mẫu</th>
                                <th>Tiêu Đề</th>
                                <th>Ngày Tạo</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($templates as $template)
                                <tr>
                                    <td>{{ $template->name }}</td>
                                    <td>{{ $template->subject }}</td>
                                    <td>{{ $template->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.email-templates.edit', $template->template_id) }}"
                                            class="btn btn-sm btn-warning">Sửa</a>
                                        <form action="{{ route('admin.email-templates.destroy', $template->template_id) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa mẫu này?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Chưa có mẫu email nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $templates->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
