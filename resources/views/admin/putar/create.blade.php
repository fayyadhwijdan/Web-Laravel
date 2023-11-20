@extends('layouts.app', ['title' => 'Tambah Pemutaran'])

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-film"></i> TAMBAH KONTEN</h6>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.putar.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label>FILE</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">

                            @error('image')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                            <br>
                            <span>Pastikan file berorientasi landscape</span>
                        </div>

                        <div class="form-group">
                            <label>DURASI</label><br>
                            <input type="radio" id="duration_10detik" name="duration" value="10detik" required>
                            <label for="duration_10detik">10 detik</label><br>
                            <input type="radio" id="duration_30detik" name="duration" value="30detik" required>
                            <label for="duration_30detik">30 detik</label>
                        </div>

                    <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i>SIMPAN</button>
                    <button class="btn btn-warning btn-reset" type="reset"><i class="fa fa-redo"></i> RESET</button>

                </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection