@extends('admin.layouts.main')

@section('title', 'Movies')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Movies</h3>
                </div>
                @if (Session::has('status'))
                    <div class="alert alert-success">
                        {{ Session::get('status') }}
                    </div>
                @endif
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('admin.movie.create') }}" class="btn btn-warning">Create Movie</a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <table id="movies" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Title</th>
                                        <th>Thumbnail</th>
                                        <th>Large Thumbnail</th>
                                        <th>Categories</th>
                                        <th>Casts</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($movie as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->title }}</td>
                                            <td><img src="{{ asset('storage/thumbnail/' . $item->small_thumbnail) }}"
                                                    width="50%"></td>
                                            <td><img src="{{ asset('storage/thumbnail/' . $item->large_thumbnail) }}"
                                                    width="50%"></td>
                                            <td>{{ $item->categories }}</td>
                                            <td>{{ $item->casts }}</td>
                                            <td><a href="{{ route('admin.movie.edit', $item->id) }}"
                                                    class="btn btn-secondary"><i class="fas fa-edit"></i>Edit</a>
                                                {{-- <a href="{{ route('') }}" class="btn btn-danger">Delete</a> --}}
                                                <form action="{{ route('admin.movie.destroy', $item->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger" type="submit">Delete</button>
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
        $('#movies').DataTable();
    </script>
@endsection
