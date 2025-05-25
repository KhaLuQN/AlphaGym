@extends('auth.layout')
@section('conten')
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>

    <section class="sign-in-page">
        <div class="container p-0">
            <div class="row no-gutters height-self-center">
                <div class="col-sm-12 align-self-center page-content rounded">
                    <div class="row m-0">
                        <div class="col-sm-12 sign-in-page-data">
                            <div class="sign-in-from bg-primary rounded">
                                <h3 class="mb-0 text-center text-white">Đăng Nhập</h3>
                                <p class="text-center text-white">Phần mềm quản lý phòng Gym</p>
                                <form method="POST" action="{{ route('login.auth') }}" class="mt-4 form-text">
                                    @csrf
                                    <div class="form-group">
                                        <label for="username">Tên đăng nhập</label>
                                        <input type="text" name="username" class="form-control mb-0" id="username"
                                            placeholder="username" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Mật khẩu</label>
                                        <input type="password" name="password" class="form-control mb-0" id="password"
                                            placeholder="Password" required>
                                    </div>

                                    <div class="sign-info text-center">
                                        <button type="submit" class="btn btn-white d-block w-100 mb-2">Đăng nhập</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
