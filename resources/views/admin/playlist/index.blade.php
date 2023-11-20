@extends('layouts.app', ['title' => 'Playlist'])

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid mb-5">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-folder-plus"></i> TEMPLATE </h6>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.playlist.index') }}" method="GET">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <a href="{{ route('admin.playlist.create') }}" class="btn btn-primary btn-sm"
                                        style="padding-top: 10px;"><i class="fa fa-plus-circle"></i> TAMBAH</a>
                                </div>
                                <input type="text" class="form-control" name="q"
                                    placeholder="cari berdasarkan nama template">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> CARI
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col" style="text-align: center;width: 6%">NO.</th>
                                    <th scope="col"style="text-align: center">TEMPLATE</th>
                                    <th scope="col"style="text-align: center">NAMA TEMPLATE</th>
                                    <th scope="col"style="text-align: center">LINK TEMPLATE</th>
                                    <th scope="col"style="text-align: center">DURASI</th>
                                    <th scope="col" style="width: 15%;text-align: center">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($playlists as $no => $playlist)
                                <tr>
                                    <th scope="row" style="text-align: center">
                                        {{ ++$no + ($playlists->currentPage()-1) * $playlists->perPage() }}</th>
                                    <td class="text-center">
                                        @php
                                            $pathInfo = pathinfo(url($playlist->image));
                                            $extension = strtolower($pathInfo['extension']);
                                        @endphp

                                        @if($extension === 'mp4')
                                            <video width="120" height="240" controls style="object-fit: cover;">
                                                <source src="{{ url($playlist->image) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        @else
                                            <img src="{{ url($playlist->image) }}" style="width:120px;height:240px;object-fit: cover;">
                                        @endif
                                    <td> {{ $playlist->name }}
                                    <td>{{ $playlist->linkcapcut }}
                                    <td class="text-center" >{{ $playlist->duration }}
                                    <td class="text-center">
                                        <button onClick="Delete(this.id)" class="btn btn-sm btn-danger"
                                            id="{{ $playlist->id }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty

                                    <div class="alert alert-danger">
                                        Data Belum Tersedia!
                                    </div>

                                @endforelse
                            </tbody>
                        </table>
                        <div style="text-align: center">
                            {{ $playlists->links("vendor.pagination.bootstrap-4") }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<script>
    //ajax delete
    function Delete(id) {
        var id = id;
        var token = $("meta[name='csrf-token']").attr("content");

        swal({
            title: "APAKAH KAMU YAKIN ?",
            text: "INGIN MENGHAPUS DATA INI!",
            icon: "warning",
            buttons: [
                'TIDAK',
                'YA'
            ],
            dangerMode: true,
        }).then(function (isConfirm) {
            if (isConfirm) {

                //ajax delete
                jQuery.ajax({
                    url: "/admin/playlist/" + id,
                    data: {
                        "id": id,
                        "_token": token
                    },
                    type: 'DELETE',
                    success: function (response) {
                        if (response.status == "success") {
                            swal({
                                title: 'BERHASIL!',
                                text: 'DATA BERHASIL DIHAPUS!',
                                icon: 'success',
                                timer: 1000,
                                showConfirmButton: false,
                                showCancelButton: false,
                                buttons: false,
                            }).then(function () {
                                location.reload();
                            });
                        } else {
                            swal({
                                title: 'GAGAL!',
                                text: 'DATA GAGAL DIHAPUS!',
                                icon: 'error',
                                timer: 1000,
                                showConfirmButton: false,
                                showCancelButton: false,
                                buttons: false,
                            }).then(function () {
                                location.reload();
                            });
                        }
                    }
                });

            } else {
                return true;
            }
        })
    }
</script>
@endsection