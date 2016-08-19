@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $product->title }}</div>

                    <div class="panel-body">
                        <ul>

                                <li>{{ $product->summary }}</li>
                                <li>{{ $product->price }}</li>

                        </ul>
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('products.destroy', $product) }}"
                              name="products.store" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa fa-btn fa-user"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection