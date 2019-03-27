@extends('layouts.admin')

@section('content')
    <section class="content-header">
        <h1>
            Paper Types
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Paper Types</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Domain configurations</h3>
                        <div class="box-tools">
                            <button data-toggle="modal" data-target="#domainsModal" class="btn btn-sm btn-info">Add Domain</button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12"><table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                        <thead>
                                        <tr role="row">
                                            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">No.</th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Name</th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Email</th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Tag line</th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Phone number</th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Domain type</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach(\App\Models\FqdnConfiguration::all() as $domain)
                                            <tr role="row" class="odd">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $domain->name }}</td>
                                                <td>{{ $domain->email }}</td>
                                                <td>{{ $domain->tag_line }}</td>
                                                <td>{{ $domain->phone_number }}</td>
                                                <td>
                                                    @if($domain->domain_type ==0)
                                                        client
                                                        @else
                                                        writer
                                                        @endif
                                                </td>
                                                <td>
                                                    <a class="btn btn-xs btn-success" href="{{ route('admin.settings.edit_domain', $domain->id) }}"><i style="" class="fa fa-edit"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">No.</th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Name</th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Action</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="domainsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" style="z-index: 100000000000;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">
                                Create/Edit domain
                            </h3>
                        </div>

                        <div class="box-body">
                            <form method="POST" action="{{ route('admin.settings.add_domain') }}">
                                @csrf

                                <input type="hidden" name="id" id="id" value="{{ old('id') }}">

                                <div class="form-group">
                                    <label for="name" class="">Name</label>
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                                    <span class="invalid-feedback" role="alert"><strong>{{ ($errors->has('name'))?$errors->first('name'):"" }}</strong></span>
                                </div>

                                <div class="form-group">
                                    <label for="name" class="">Email</label>
                                    <input id="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="name" value="{{ old('email') }}" required autofocus>
                                    <span class="invalid-feedback" role="alert"><strong>{{ ($errors->has('name'))?$errors->first('name'):"" }}</strong></span>
                                </div>

                                <div class="form-group">
                                    <label for="name" class="">Tag line</label>
                                    <input id="tag_line" type="text" class="form-control{{ $errors->has('tag_line') ? ' is-invalid' : '' }}" name="tag_line" value="{{ old('tag_line') }}" required autofocus>
                                    <span class="invalid-feedback" role="alert"><strong>{{ ($errors->has('tag_line'))?$errors->first('tag_line'):"" }}</strong></span>
                                </div>

                                <div class="form-group">
                                    <label for="phone_number" class="">Phone number</label>
                                    <input id="phone_number" type="text" class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" name="phone_number" value="{{ old('phone_number') }}" required autofocus>
                                    <span class="invalid-feedback" role="alert"><strong>{{ ($errors->has('phone_number'))?$errors->first('phone_number'):"" }}</strong></span>
                                </div>

                                <div class="form-group">
                                    <label for="domain_type" class="">Domain clientele</label>
                                    <select name="domain_type" class="form-control" id="">
                                        <option value="0" {{ (old('domain_type')==0)?"selected":"" }}>Client site</option>
                                        <option value="1" {{ (old('domain_type')==1)?"selected":"" }}>Writers site</option>
                                    </select>
                                    <span class="invalid-feedback" role="alert"><strong>{{ ($errors->has('domain_type'))?$errors->first('domain_type'):"" }}</strong></span>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
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

        $(function () {
            @if(count($errors->all)>0 || old('id')!=null)
            $('#domainsModal').modal('show');
            @endif
        })

    </script>
@stop