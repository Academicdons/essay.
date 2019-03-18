@extends('layouts.admin')

@section('content')
    <section class="content-header">
        <h1>
            Discipline
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Group</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Groups</h3>
                        <div class="box-tools">
                            <button data-toggle="modal" data-target="#disciplinesModal" class="btn btn-sm btn-info">Add Group</button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12"><table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                        <thead>
                                        <tr role="row">
                                            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">No.</th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Name</th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Base Price</th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Writer Price</th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach(\App\Models\Group::all() as $group)
                                            <tr role="row" class="odd">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $group->name }}</td>
                                                <td>{{ $group->base_price }}</td>
                                                <td>{{ $group->writer_price }}</td>
                                                <td>
                                                    <a href="javascript:editDiscipline('{{ $group->id }}')"><i class="fa fa-edit"></i></a>
                                                    <a href="{{ route('admin.discipline.delete', $group->id) }}"><i style="color: red;" class="fa fa-trash-o"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        {{--<tr>--}}
                                            {{--<th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">No.</th>--}}
                                            {{--<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Name</th>--}}
                                            {{--<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Action</th>--}}
                                        {{--</tr>--}}
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="disciplinesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" style="z-index: 100000000000;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="box">
                        <div class="box-header">
                            <div class="box-title" id="album_name"></div>
                        </div>

                        <div class="box-body">
                            <form method="POST" action="{{ route('admin.discipline.add_grouping') }}">
                                @csrf

                                <input type="hidden" name="id" id="id" value="{{ old('id') }}">

                                <div class="form-group col-md-6">
                                    <label for="name" class=" col-form-label text-md-right">Name</label>

                                    <div class="">
                                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group col-md-6">
                                    <label for="base_price" class=" col-form-label text-md-right">Base Price</label>

                                    <div class="">
                                        <input id="base_price" type="text" class="form-control{{ $errors->has('base_price') ? ' is-invalid' : '' }}" name="base_price" value="{{ old('base_price') }}" required >

                                        @if ($errors->has('base_price'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('base_price') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group col-md-6">
                                    <label for="writer_price" class=" col-form-label text-md-right">Writer Price</label>

                                    <div class="">
                                        <input id="writer_price" type="text" class="form-control{{ $errors->has('writer_price') ? ' is-invalid' : '' }}" name="writer_price" value="{{ old('writer_price') }}" required >

                                        @if ($errors->has('writer_price'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('writer_price') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group col-md-6 mt-2 mb-0">
                                    <div class=" offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('script')
    <script>
        function editDiscipline(discipline_id) {
            var base_url = '{{ route('admin.discipline.index') }}';
            var url = base_url + '/edit'+'/'+discipline_id;

            axios.get(url)
                .then(function (res) {
                    console.log(res);

                    $('#id').val(res.data.discipline.id);
                    $('#name').val(res.data.discipline.name);
                    $('#disciplinesModal').modal('show');
                })
        }
    </script>
@stop