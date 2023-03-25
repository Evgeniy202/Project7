@extends('layouts.app')
@section('title', 'Project7 - Support')
@section('content')
    <div class="container">
        <h3>Support</h3>
        <hr>
        <div class="text-dark">
            <div class="col-md-12">
                <h3 class=""></h3>
                <form action="{{ route('create-support') }}" method="POST" class="p-5">
                    @csrf
                    <input type="text" id="name" name="name" class="form-control m-2" placeholder="You name..."
                           required>
                    <input type="text" id="contact" name="contact" class="form-control m-2"
                           placeholder="You phone number or email..." required>
                    <textarea id="information" name="information" class="form-control m-2" rows="5"
                              placeholder="Describe the subject of the appeal..." required></textarea>
                    <input type="submit" class="btn btn-outline-success m-2 col-12" value="Send application">
                </form>
            </div>
        </div>
    </div>
@endsection
