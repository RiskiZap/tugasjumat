@extends('home')
@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
  {{session('success')}}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
</div>
@endif
<div class="text-end mb-2">
<a class="btn btn-warning" href="{{ route('petugass.chartLine') }}"> Chart</a>
  <a class="btn btn-success" href="{{ route('petugass.create') }}"> Add Petugas</a>
</div>
<table id="example" class="table table-striped" style="width:100%">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Id Petugas</th>
      <th scope="col">Nama Petugas</th>
      <th scope="col">Bulan</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
    @php $no = 1 @endphp
    @foreach ($petugas as $data)
    <tr>
      <td>{{ $no ++ }}</td>
      <!-- <td>{{ $data->id }}</td> -->
      <td>{{ $data->id_petugas }}</td>
      <td>{{ 
            (isset($data->getManager->name)) ?
            $data->getManager->name :
            'Tidak Ada'
            }}
        </td>
        <td>{{ $data->detail->count() }}</td>
        <td>{{ $data->bulan }}</td>
      <td>
        <form action="{{ route('petugass.destroy',$data->id) }}" method="Post">
          <a class="btn btn-primary" href="{{ route('petugass.edit',$data->id) }}">Edit</a>
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
  $(document).ready(function() {
    $('#example').DataTable();
  });
</script>
@endsection