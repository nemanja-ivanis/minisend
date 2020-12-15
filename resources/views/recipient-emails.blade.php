@extends('layout.main')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8 ">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        {{$email}} - Recipient Emails
                        <a href="/" class="btn btn-primary">Go Back</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            <thead>
                                <th >Id</th>
                                <th>Sender</th>
                                <th>Recipient</th>
                                <th>Subject</th>
                                <th>Status</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach($emails as $email)
                                    <tr>
                                        <td>{{$email->id}}</td>
                                        <td>{{$email->from}}</td>
                                        <td>{{$email->to}}</td>
                                        <td>{{$email->subject}}</td>
                                        <td>{{$email->status}}</td>
                                        <td><a href="{{route('viewEmail', ['id' => $email->id])}}">View Email</a></td>

                                    </tr>
                                @endforeach

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
