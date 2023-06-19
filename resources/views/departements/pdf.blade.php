@extends('layout')
@section('content')
<table class="table mt-5">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Nama</th>
            <th scope="col">Location</th>
            <th scope="col">Manager Name</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 0; ?>
        @foreach ($departements as $departement)
        <?php $no++; ?>
        <tr>
            <td>{{ $no }}</td>
            <td>{{ $departement->name }}</td>
            <td>{{ $departement->location }}</td>
            <td>{{
                (isset($departement->getManager->name))?
                $departement->getManager->name :
                'Tidak Ada' 
                }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection