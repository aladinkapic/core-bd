@extends('template.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h4>Unos komentara</h4>
                <hr />

                <form method="POST" action="{{ route('feedback.create') }}">
                    @csrf
                    Komentar:
                    <textarea class="form-control" name="komentar"></textarea><br />

                    <button class="btn btn-success"><i class="fa fa-plus"></i> Dodaj</button>
                </form>
            </div>
            <div class="col-md-8">
                <h4>Prijavljeni komentari</h4>
                <hr />

                @foreach($feedbacks as $feedback)

                    <div class="card">
                        <div class="card-header" style="    padding: 14px;">
                            <div class="float-right">
                                {{ $feedback->created_at }}
                            </div>
                            {{ $feedback->sl->ime }} {{ $feedback->sl->prezime }}
                        </div>
                        <div class="card-body" style="    padding: 14px;">
                            <form class="float-right" method="POST" action="{{ route('feedback.delete') }}">
                                @method('delete')
                                @csrf
                                <input type="hidden" name="id" value="{{ $feedback->id }}" />
                                <button class="btn btn-danger btn-xs float-right"><i class="fa fa-times"></i> Obrisi</button>
                            </form>
                            <p class="card-text">{{ $feedback->komentar }}</p>

                        </div>
                    </div>
                    <br />

                @endforeach
            </div>
        </div>
    </div>
@endsection