@extends('layouts.master')
@section('css')
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                المنتاجات</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
@include('alerts.success')
@include('alerts.erorrs')

<!-- row -->
<div class="row">
    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <div class="col-sm-6 col-md-4 col-xl-3">
                        <button type="button" class="button x-small btn btn-outline-primary" data-toggle="modal"
                            data-target="#exampleModal"><i class="fas fa-plus"></i>&nbsp; اضافة منتج</button><br><br>
                    </div> <i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'>
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">اسم المنتج</th>
                                <th class="border-bottom-0">القسم</th>
                                <th class="border-bottom-0">ملاحظات</th>
                                <th class="border-bottom-0">العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0 ?>
                            @foreach ($products as $product)
                            <?php $i++?>
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$product->product_name}}</td>
                                <td>{{$product->sections->section_name}}</td>
                                <td>{{$product->description}}</td>
                                <td>
                                    <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                        data-pro_id="{{$product->id}}" data-name="{{ $product->product_name }}"
                                        data-section_name="{{ $product->sections->section_name }}"
                                        data-description="{{ $product->description }}" data-toggle="modal"
                                        href="#edit_Product" title="تعديل"><i class="las la-pen"></i></a>



                                    <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                        data-id="{{ $product->id }}" data-product_name="{{ $product->product_name }}"
                                        data-toggle="modal" href="#modaldemo9" title="حذف"><i
                                            class="las la-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Add -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">اضافة منتج</h5>
                <button type="button" class="close btn-primary" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('products.store')}}" method="post">
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">اسم المنتج</label>
                        <input type="text" class="form-control" id="product_name" name="product_name" required>

                    </div>

                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">القسم</label>
                    <select name="section_id" id="section_id" class="form-control" required>
                        <option value="" selected disabled> --حدد القسم--</option>
                        @foreach ($sections as $section)
                        <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                        @endforeach
                    </select>

                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">ملاحظات</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">تاكيد</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--  end add -->
<!-- edit -->
<div class="modal fade" id="edit_Product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تعديل منتج</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @isset($product)
            <form action="{{route('products.update' , $product->id)}}" method="post">
                {{ method_field('put') }}
                {{ csrf_field() }}
                <div class="modal-body">

                    <div class="form-group">
                        <label for="title">اسم المنتج :</label>

                        <input type="hidden" class="form-control" name="pro_id" id="pro_id" value="">

                        <input type="text" class="form-control" name="product_name" id="product_name">
                    </div>

                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">القسم</label>
                    <select name="section_name" id="section_name" class="custom-select my-1 mr-sm-2" required>
                        @foreach ($sections as $section)
                        <option>{{ $section->section_name }}</option>
                        @endforeach
                    </select>

                    <div class="form-group">
                        <label for="des">ملاحظات :</label>
                        <textarea name="description" cols="20" rows="5" id='description'
                            class="form-control"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">تعديل البيانات</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                </div>
            </form>
            @endisset

        </div>
    </div>
</div>

<!-- delete -->
<div class="modal fade" id="modaldemo9" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">حذف المنتج</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @isset($product)
            <form action="{{route('products.destroy' , $product->id)}}" method="post">
                {{ method_field('delete') }}
                {{ csrf_field() }}
                <div class="modal-body">
                    <p>هل انت متاكد من عملية الحذف ؟</p><br>
                    <input type="hidden" name="id" id="id" value="">
                    <input class="form-control" name="product_name" id="product_name" type="text" readonly>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                    <button type="submit" class="btn btn-danger">تاكيد</button>
                </div>
            </form>
            @endisset

        </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
<script>
    $('#edit_Product').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var Product_name = button.data('name')
        var section_name = button.data('section_name')
        var pro_id = button.data('pro_id')
        var description = button.data('description')
        var modal = $(this)
        modal.find('.modal-body #product_name').val(Product_name);
        modal.find('.modal-body #section_name').val(section_name);
        modal.find('.modal-body #description').val(description);
        modal.find('.modal-body #pro_id').val(pro_id);
    })
    $('#modaldemo9').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var product_name = button.data('product_name')
        var modal = $(this)

        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #product_name').val(product_name);
    })

</script>
@endsection
