@extends('home')
@section('content')
<form action="{{ route('departements.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Departement Name:</strong>
                <input type="text" name="name" class="form-control" placeholder="Departement Name">
                @error('name')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Location :</strong>
                <input type="text" name="location" class="form-control" placeholder="Location">
                @error('location')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="manager_id">Manager</label>
            <select name="manager_id" id="manager_id" class="form-select">
                <option value="">Pilih</option>
                @foreach ($managers as $manager)
                <option value="{{ $manager->id }}">{{ $manager->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-3 ml-3">Submit</button>
    </div>
</form>
@endsection