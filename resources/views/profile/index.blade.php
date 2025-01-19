@extends('layouts.main')

@section('content')
<main class="main-content position-relative border-radius-lg">
    <div class="container-fluid py-4">
        <!-- Header Profile -->
        <div class="bg-primary text-center py-5 mb-4" style="border-radius: 10px;">
            <div class="d-flex justify-content-center">
                <div class="rounded-circle bg-light" style="width: 100px; height: 100px; display: flex; align-items: center; justify-content: center;">
                    <i class="fa fa-user fa-3x text-secondary"></i>
                </div>
            </div>
            <h4 class="mt-3 text-white">{{ $user->name }}</h4>
            <p class="text-success mb-0">Online</p>
        </div>

        <!-- Form Profile -->
        <div class="card shadow-lg p-4">
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="name">Nama Pengguna</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}" placeholder="Masukkan Nama Pengguna">
                        </div>
                        <div class="form-group mb-3">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" class="form-control" value="{{ $user->username }}" placeholder="Masukkan Username">
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="email">E-mail</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" placeholder="Masukkan Alamat E-mail">
                        </div>
                        <div class="form-group mb-3">
                            <label for="role">Role</label>
                            <select id="role" name="role" class="form-control">
                                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Tombol Simpan -->
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection
