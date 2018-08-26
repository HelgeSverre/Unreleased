@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        Genre name
                    </div>
                    <div class="card-body">
                        {{$genre->name}}
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        About the genre
                    </div>
                    <div class="card-body">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                        nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore
                        eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    </div>
                </div>
            </div>
        </div>
        <br><br>
        @foreach ($tracks as $artist_id => $tracks)

            <div class="card">
                <div class="card-header bg-dark text-white">
                    Tracks by <strong>{{$tracks->first()->artist->stage_name}}</strong> in the <strong>{{$genre->name}}</strong> Genre
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Edit</th>
                            <th>Genre</th>
                            <th>Added</th>
                            <th>Source</th>
                            <th>Release status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($tracks as $track)
                            <tr>
                                <td>{{ $track->id }}</td>
                                <td>{{ $track->title }}</td>
                                <td><a href="{{route('track.edit', $track->id)}}">Edit</a></td>
                                <td>{{ $track->genre->name }}</td>
                                <td>{{ $track->created_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ $track->source_url }}" rel="nofollow" target="_blank">
                                        {{ $track->source_description }}
                                    </a>
                                </td>
                                <td>
                                    <div class="badge badge-success">{{ $track->release_status }}</div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
            <br><br>
        @endforeach
    </div>
@endsection
