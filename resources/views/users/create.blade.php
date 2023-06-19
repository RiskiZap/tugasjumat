@extends('app')
@section('content')
<form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>User Name:</strong>
                <input type="text" name="name" class="form-control" placeholder="User Name">
                @error('name')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Email :</strong>
                <input type="email" name="email" class="form-control" placeholder="Email">
                @error('email')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Password :</strong>
                <input type="password" name="password" class="form-control" placeholder="Password">
                @error('password')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Position :</strong>
                <input type="number" name="position" class="form-control" placeholder="Position">
                @error('position')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Departement :</strong>
                <input type="number" name="departement" class="form-control" placeholder="Departement">
                @error('departement')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3 ml-3">Submit</button>
    </div>
</form>
@endsection