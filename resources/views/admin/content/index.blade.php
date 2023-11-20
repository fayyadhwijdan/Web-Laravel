@extends('layouts.app', ['title' => 'Content'])

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid mb-5">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold"><i class="fa fa-camera"></i> CONTENT</h6>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.content.index') }}" method="GET">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="q" 
                                placeholder="cari berdasarkan upload content">
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
                                    <th scope="col"style="text-align: center">NO.</th>
                                    <th scope="col"style="text-align: center">NAMA KONTEN</th>
                                    <th scope="col"style="text-align: center">FILE KONTEN</th>
                                    <th scope="col"style="text-align: center">TEMPLATE</th>
                                    <th scope="col"style="text-align: center">NAMA PENGIRIM</th>
                                    <th scope="col"style="text-align: center">STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($posts as $no => $post)
                                <tr>
                                    <th scope="row" style="text-align: center">
                                        {{ $posts->total() - $no - (($posts->currentPage()-1) * $posts->perPage()) }}</th>
                                    <td>{{ $post->title }}</td>
                                    <td class="text-center">
                                        @php
                                            $pathInfo = pathinfo(url($post->image));
                                            $extension = strtolower($pathInfo['extension']);
                                        @endphp

                                        @if($extension === 'mp4')
                                            <video height="240" controls style="object-fit: cover;">
                                                <source src="{{ url($post->image) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        @else
                                            <img src="{{ url($post->image) }}" style="height:180px;">
                                        @endif
                                    </td>
                                    <td>{{ $post->template }}</td>
                                    <td>{{ $post->sender }}</td>
                                    <td class="text-center">
                                        @if(!$post->approved)
                                            <form action="{{ route('admin.content.approve', $post->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                            </form>
                                        @else
                                            <span class="badge badge-success">Approved</span>
                                        @endif
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
                            {{$posts->links("vendor.pagination.bootstrap-4")}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection
