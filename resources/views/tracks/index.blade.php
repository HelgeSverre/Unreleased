@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        Recently added tracks
                    </div>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Artist</th>
                            <th>Title</th>
                            <th>Edit</th>
                            <th>Genre</th>
                            <th>Added</th>
                            <th>Source</th>
                            <th>Release status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($tracks as $track)
                            <tr>
                                <td>{{ $track->id }}</td>
                                <td>
                                  <a href="{{route('artist.show', $track->artist_id)}}">
                                    {{ $track->artist->stage_name }}
                                  </a>
                                </td>
                                <td>{{ $track->title }}</td>
                                <td> <a href="{{route('track.edit', $track->id)}}">Edit</a> </td>
                                <td>
                                  <a href="{{route('genre.show', $track->genre_id)}}">
                                    {{ $track->genre->name }}</td>
                                  </a>
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
                        @empty
                            <tr>
                                <td colspan="7">No tracks added yet</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
