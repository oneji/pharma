@extends('layouts.main')

@section('head')
    @parent
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-content">
                <form method="POST" action="{{ route('excel.import') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="excel_file" />
                    <hr>
                    <button type="submit" class="btn btn-small green">Submit</button>
                </form>
                <hr>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
@endsection