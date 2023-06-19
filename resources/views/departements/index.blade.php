@extends('home')
@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
  {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="text-end mb-2">
                    <a class="btn btn-light" href="{{ route('departements.export-Pdf') }}"> Export</a>
                    <a class="btn btn-success" href="{{ route('departements.create') }}"> Add Departement</a>
                    
                </div>
<table id="example" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nama</th>
            <th scope="col">Lokasi</th>
            <th scope="col">Manager Name</th>
            <th width="280px">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($departements as $departement)
    <tr>
        <td>{{ $departement->id }}</td>
        <td>{{ $departement->name }}</td>
        <td>{{ $departement->location }}</td>
        <td>{{ 
            (isset($departement->getManager->name)) ?
            $departement->getManager->name :
            'Tidak Ada'
            }}
        </td>
        <td>
            <form action="{{ route('departements.destroy',$departement->id) }}" method="Post">
                <a class="btn btn-primary" href="{{ route('departements.edit',$departement->id) }}">Edit</a>
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
@endsection
@section('js')
<script>
    $(document).ready(function () {
    $('#example').DataTable();
});
</script>
@endsection