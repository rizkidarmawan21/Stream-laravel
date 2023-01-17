@extends('admin.layouts.base');

@section('title', 'Movies')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Movies</h3>
                </div>

                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <a href="{{ route('admin.movie.create') }}" class="btn btn-warning">Create Movie</a>
                        </div>
                    </div>

                    @if (session()->has('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <table id="movie" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Title</th>
                                        <th>Small Thumbnail</th>
                                        <th>Large Thumbnail</th>
                                        <th>Categories</th>
                                        <th>Casts</th>
                                        <th>Featured</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($movies as $movie)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $movie->title }}</td>
                                            <td>
                                                <img src="{{ asset('storage/' . $movie->small_thumbnail) }}" width="100px"
                                                    alt="">
                                            </td>
                                            <td>
                                                <img src="{{ asset('storage/' . $movie->large_thumbnail) }}" width="100px"
                                                    alt="">
                                            </td>
                                            <td>{{ $movie->categories }}</td>
                                            <td>{{ $movie->casts }}</td>
                                            <td>{{ $movie->featured == '1' ? 'Yes' : 'No' }}</td>
                                            <td>
                                                <a href="{{ route('admin.movie.edit', $movie->id) }}"
                                                    class="btn btn-secondary">Edit</a>

                                                <form action="{{ route('admin.movie.destroy', $movie->id) }}"
                                                    method="post"
                                                    onclick="return confirm('Yakin anda akan menghapus data ini ?')">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn mt-1 btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $('#movie').DataTable();
    </script>
@endsection
