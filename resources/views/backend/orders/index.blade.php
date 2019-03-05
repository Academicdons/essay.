@extends('layouts.admin')

@section('content')
    <section class="content-header">
        <h1>
            Orders
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Orders</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Orders</h3>
                        <div class="box-tools">
                            <a href="{{ route('admin.orders.new') }}" class="btn btn-sm btn-info">New Order</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12"><table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                        <thead>
                                        <tr role="row">
                                            <th>No.</th>
                                            <th>Order No.</th>
                                            <th>Title</th>
                                            <th>No. Pages</th>
                                            <th>No. Words</th>
                                            <th>Amount</th>
                                            <th>Order Expiry Time</th>
                                            <th>Deadline</th>
                                            <th>Order Assign Type</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach(\App\Models\Order::all() as $order)
                                            <tr role="row" class="odd">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $order->order_no }}</td>
                                                <td>{{ $order->title }}</td>
                                                <td>{{ $order->no_pages }}</td>
                                                <td>{{ $order->no_words }}</td>
                                                <td>{{ $order->amount }}</td>
                                                <td>{{ $order->bid_expiry }}</td>
                                                <td>{{ $order->deadline }}</td>
                                                <td>
                                                    @if($order->order_assign_type == 1)
                                                        <i class="badge badge-info">Bid</i>
                                                    @elseif($order->order_assign_type == 2)
                                                        <i class="badge badge-light">Take</i>
                                                    @else
                                                        <i class="badge badge-primary">Manual</i>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{--<a href="javascript:editOrder('{{ $order->id }}')"><i class="fa fa-edit"></i></a>--}}
                                                    <a href="{{ route('admin.orders.edit', $order->id) }}"><i class="fa fa-edit"></i></a>
                                                    <a href="{{ route('admin.orders.delete', $order->id) }}"><i style="color: red;" class="fa fa-trash-o"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>No.</th>
                                            <th>Order No.</th>
                                            <th>Title</th>
                                            <th>No. Pages</th>
                                            <th>No. Words</th>
                                            <th>Amount</th>
                                            <th>Order Expiry Time</th>
                                            <th>Deadline</th>
                                            <th>Order Assign Type</th>
                                            <th>Action</th>
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

        <div class="modal fade" id="edlevelsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" style="z-index: 100000000000;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="box">
                        <div class="box-header">
                            <div class="box-title" id="album_name"></div>
                        </div>

                        <div class="box-body">
                            <form method="POST" action="{{ route('admin.education_level.add') }}">
                                @csrf

                                <input type="hidden" name="id" value="{{ old('id') }}">

                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                        @endif
                                    </div>
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