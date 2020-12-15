@extends('layout.main')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8 ">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        Attachments
                        <a href="/" class="btn btn-primary">Go Back</a>
                    </div>
                    <div class="card-body">
                        <ul>
                            @foreach($attachments as $attachment)
                                <li><a href="{{route('downloadAttachment', ['id' => $attachment->id])}}">{{$attachment->path}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
