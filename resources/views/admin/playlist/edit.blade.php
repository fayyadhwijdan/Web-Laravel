@extends('layouts.app', ['title' => 'Edit Playlist'])

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-folder"></i> EDIT TEMPLATE</h6>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.playlist.update', $playlist->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>TEMPLATE</label>
                            <input type="file" name="image" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>NAMA TEMPLATE</label>
                            <input type="text" name="name" value="{{ old('name', $playlist->name) }}" placeholder="Masukkan Nama Template" class="form-control @error('name') is-invalid @enderror">

                            @error('name')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>

                        <div class="form-group">
                            <label>LINK TEMPLATE</label>
                            <textarea class="form-control linkcapcut @error('lipcapcut') is-invalid @enderror" name="linkcapcut" rows="6"
                                placeholder="Masukkan Link Template">{{ old('linkcapcut') }}</textarea>
                            @error('linkcapcut')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                        
                        </div>

                        <div class="form-group">
                            <label>DURASI</label><br>
                            <input type="radio" id="duration_10detik" name="duration" value="10detik" required>
                            <label for="duration_10detik">10 detik</label><br>
                            <input type="radio" id="duration_30detik" name="duration" value="30detik" required>
                            <label for="duration_30detik">30 detik</label>
                        </div>

                        <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i> UPDATE</button>
                        <button class="btn btn-warning btn-reset" type="reset"><i class="fa fa-redo"></i> RESET</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection