@extends('app')
@section('content')
<form action="{{ route('petugass.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>ID Petugas:</strong>
                <input type="text" name="id_petugas" class="form-control" placeholder="ID Petugas">
                @error('name')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Nama Petugas:</strong>
                <select name="nama_petugas" id="nama_petugas" class="form-select" >
                        <option value="">Pilih</option>
                        @foreach($managers as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                </select>
                @error('alias')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Bulan:</strong>
                <input type="date" name="bulan" class="form-control" placeholder="Bulan">
                @error('name')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row col-xs-12 col-sm-12 col-md-12 mt-3">
            <div class="col-md-10 form-group">
                <input type="text" name="search" id="search" class="form-control" placeholder="Masukan Nama Masjid">
                @error('nama')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-2 form-group text-center">
                <button class="btn btn-secondary" type="button" name="btnAdd" id="btnAdd"><i class="fa fa-plus"></i>Tambah</button>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                    <th scope="col">NO</th>
                    <th scope="col">Nama Masjid</th>
                    <th scope="col">Bagian</th>
                
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody id="detail">
                    
                </tbody>
            </table>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Jumlah Mesjid :</strong>
                <input type="text" name="jml" class="form-control" placeholder="Jumlah Mesjid">
                @error('bulan')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3 ml-3">Submit</button>
    </div>
</form>
@endsection
@section('js')
<script type="text/javascript">
    var path = "{{ route('search.masjid') }}";

    $("#search").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: path,
                type: 'GET',
                dataType: "json",
                data: {
                    search: request.term
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        select: function(event, ui) {
            $('#search').val(ui.item.label);
            console.log($("input[name='jml']").val());
            if ($("input[name='jml']").val() > 0) {
                for (let i = 1; i <= $("input[name='jml']").val(); i++) {
                    id = $("input[name='id_masjid" + i + "']").val();
                    if (id == ui.item.id) {
                        alert(ui.item.value + ' sudah ada!');
                        break;
                    } else {
                        add(ui.item.id);
                    }
                }
            } else {
                add(ui.item.id);
            }
            return false;
        }
    });

    function add(id) {
        const path = "{{ route('masjids.index') }}/" + id;
        var html = "";
        var no = 0;
        if ($('#detail tr').length > 0) {
            var html = $('#detail').html();
            no = no + $('#detail tr').length;
        }
        $.ajax({
            url: path,
            type: 'GET',
            dataType: "json",
            success: function(data) {
                console.log(data);
                no++;
                html += '<tr>' +
                    '<td>' + no + '<input type="hidden" name="id_masjid' + no + '" class="form-control" value="' + data.id + '"></td>' +
                    '<td><input type="text" name="nama_masjid' + no + '" class="form-control" value="' + data.nama_masjid + '"></td>' +
                    '<td><input type="text" name="bagian' + no + '" class="form-control"></td>' +
                    '<td><a href="#" class="btn btn-sm btn-danger">Delete</a></td>' +
                    '</tr>';
                $('#detail').html(html);
                $("input[name='jml']").val(no);
            }
        });
    }
</script>


</script>
@endsection