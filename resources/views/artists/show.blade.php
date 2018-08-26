@extends('layouts.app')

@section('content')
    <div class="container">
      <h1 class="text-center">{{$artist->stage_name}}<a href="{{route('artist.edit', $artist->id)}}" class="btn btn-info float-right">Edit</a></h1>

        <div class="row">
          <div class="col-md-4">
            <div class="card">
              <div class="card-header bg-dark text-white">
                Real name
              </div>
              <div class="card-body">
                {{$artist->real_name}}
              </div>
            </div>
          </div>
          <div class="col-md-8">
            <div class="card">
              <div class="card-header bg-dark text-white">
                Bio
              </div>
              <div class="card-body">
                {{$artist->bio}}
              </div>
            </div>


          </div>
        </div>
        <br>
        @if ($artist->discogs_bio)
          <div class="card">
            <div class="card-header bg-dark text-white">
              Bio from Discogs
            </div>
            <div class="card-body">
              {{$artist->discogs_bio}}
            </div>
          </div>
        @endif
        <br>

        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        Tracks by {{$artist->stage_name}}
                    </div>
                    <div class="card-body">
                      @if(count($artist->tracks)>0)
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
                        @foreach ($artist->tracks as $track)
                                  <tr>
                                      <td>{{ $track->id }}</td>
                                      <td>{{ $track->title }}</td>
                                      <td> <a href="{{route('track.edit', $track->id)}}">Edit</a> </td>
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
                      @else
                        There are no tracks assigned to this artist - yet!
                      @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
