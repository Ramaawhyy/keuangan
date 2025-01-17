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
            <h4 class="mt-3 text-white">USER447681209904</h4>
            <p class="text-success mb-0">Online</p>
        </div>

        <!-- Form Profile -->
        <div class="card shadow-lg p-4">
            <form>
                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="username">Nama Pengguna</label>
                            <input type="text" id="username" class="form-control" placeholder="Masukkan Nama Pengguna">
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">E-mail</label>
                            <input type="email" id="email" class="form-control" placeholder="Masukkan Alamat E-mail">
                        </div>
                        <div class="form-group mb-3">
                            <label for="phone">No. Telp</label>
                            <input type="text" id="phone" class="form-control" placeholder="Masukkan No Telp">
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="profilePhoto">Foto Profil</label>
                            <div class="d-flex">
                                <input type="file" id="profilePhoto" class="form-control" style="flex: 1;">
                                <button type="button" class="btn btn-primary ms-2">Unggah Foto</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Baris Kata Sandi -->
                <div class="row mt-4">
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="password">Kata Sandi</label>
                            <input type="password" id="password" class="form-control" placeholder="Masukkan Kata Sandi">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="changePassword">Ubah Kata Sandi</label>
                            <input type="password" id="changePassword" class="form-control mb-2" placeholder="Masukkan Kata Sandi Saat Ini">
                            <button type="button" class="btn btn-secondary">Ubah Kata Sandi</button>
                        </div>
                    </div>
                </div>

                <!-- Tombol Simpan dan Edit -->
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-warning">Edit</button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection
