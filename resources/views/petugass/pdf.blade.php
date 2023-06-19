@extends('layout')
@section('content')
<table class="table mt-3">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nama</th>
      <th scope="col">Keterangan</th>
      <th scope="col">Manager Name</th>
    </tr>
  </thead>
  <tbody>
    <?php $no = 1; ?>
    @foreach ($departements as $data)
    
    <tr>
        <td>{{ $no }}</td>
        <td>{{ $data->name }}</td>
        <td>{{ $data->location }}</td>
        <td>{{ 
          (isset($data->getManager->name)) ? 
          $data->getManager->name : 
          'Tidak Ada'
          }}
        </td>
    </tr>
    <?php $no++; ?>
    @endforeach
  </tbody>
</table>
@endsection