@extends('layouts.master')
@section('title' , 'لوحة التحكم - برنامج الفواتير')
@section('css')
    <!--  Owl-carousel css -->

    <link href="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.css')}}"  rel="stylesheet" />
    <!-- Maps css -->
    <link href="{{URL::asset('assets/plugins/jqvmap/jqvmap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
 <link
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
  rel="stylesheet"
/>
<!-- Google Fonts -->
<link
  href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
  rel="stylesheet"
/>
<!-- MDB -->
<link
  href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.1.0/mdb.min.css"
  rel="stylesheet"
/>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">مرحبًا بك مرة أخرى!</h2>
                <p class="mg-b-0">قالب لوحة مراقبة المبيعات.</p>
            </div>
        </div>
        <div class="main-dashboard-header-right">
            <div>
                <label class="tx-13">تقييمات العملاء</label>
                <div class="main-star">
                    <i class="typcn typcn-star active"></i> <i class="typcn typcn-star active"></i> <i class="typcn typcn-star active"></i> <i class="typcn typcn-star active"></i> <i class="typcn typcn-star"></i> <span>(14,873)</span>
                </div>
            </div>
            <div>
                <label class="tx-13">المبيعات عبر الإنترنت</label>
                <h5>563,275</h5>
            </div>
            <div>
                <label class="tx-13">المبيعات دون لإنترنت</label>
                <h5>783,675</h5>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-primary-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">اجمالي الفواتير   </h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">${{number_format(\App\Models\invoices::sum('total'),2)}}</h4>
                                <p class="mb-0 tx-12 text-white op-7">عدد الفواتير   <span class="bg-primary">{{\App\Models\invoices::count()}}</span></p>
                            </div>
                            <span class="float-right my-auto mr-auto">
								<i class="fas fa-arrow-circle-up text-white"></i>
								<span class="text-white op-7"> 100%</span>
							</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-danger-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">اجمالي الفواتير الغير مدفوعة </h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">${{number_format(\App\Models\invoices::where('value_status','2')->sum('total'),2)}}</h4>
                                <p class="mb-0 tx-12 text-white op-7">عدد الفواتير الغير المدفوعة <span class="bg-danger">{{\App\Models\invoices::where('value_status','2')->count()}}</span></p>
                            </div>
                            <span class="float-right my-auto mr-auto">
											{{-- <i class="fas fa-arrow-circle-down text-white"> %{{round(\App\Models\invoices::where('value_status','2')->count() /\App\Models\invoices::count() * 100 ) }}</i> --}}
											<span class="text-white op-7"></span>
										</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-success-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">اجمالي الفواتير المدفوعة</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">${{number_format(\App\Models\invoices::where('value_status','1')->sum('total'),2)}}</h4>
                                <p class="mb-0 tx-12 text-white op-7"> عدد الفواتير المدفوعة <span class="bg-success">{{\App\Models\invoices::where('value_status','1')->count()}}</span></p>
                            </div>
                            <span class="float-right my-auto mr-auto">
											<i class="fas fa-arrow-circle-up text-white"></i>
											{{-- <span class="text-white op-7">%{{round(\App\Models\invoices::where('value_status','1')->count() /\App\Models\invoices::count() * 100) }}</span> --}}
										</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-warning-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">اجمالي الفواتير المدفوعة جزئيا</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">${{number_format(\App\Models\invoices::where('value_status','3')->sum('total'),2)}}</h4>
                                <p class="mb-0 tx-12 text-white op-7">عدد الفواتير المدفوعة جزئيا <span class="bg-orange">{{\App\Models\invoices::where('value_status','3')->count()}}</span></p>
                            </div>
                            <span class="float-right my-auto mr-auto">
											<i class="fas fa-arrow-circle-down text-white"></i>
											{{-- <span class="text-white op-7">%{{round(\App\Models\invoices::where('value_status','3')->count() /\App\Models\invoices::count() * 100) }}</span> --}}
										</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->

    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-md-12 col-lg-12 col-xl-7">
            <div class="card">
                <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-0">حالة الفواتير</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <p class="tx-12 text-muted mb-0">حالة جميع الفواتير المدفوعة والغير مدفوعة والمدفوعة جزئيا.</p>
                </div>
                <div class="card-body">
                    {!! $chartjs->render() !!}
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-xl-5">
            <div class="card card-dashboard-map-one">
                <label class="main-content-label"></label>إيرادات المبيعات من قبل العملاء</label>
                <span class="d-block mg-b-20 text-muted tx-12">أداء المبيعات لجميع المنتجات</span>
                <div class="">
                    {!! $chartjs_2->render() !!}
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
    </div>
    </div>
    <!-- Container closed -->
@endsection
@section('js')
    <!--Internal  Chart.bundle js -->
    <script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
    <!-- Moment js -->
    <script src="{{URL::asset('assets/plugins/raphael/raphael.min.js')}}"></script>
    <!--Internal  Flot js-->
    <script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.pie.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.resize.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.categories.js')}}"></script>
    <script src="{{URL::asset('assets/js/dashboard.sampledata.js')}}"></script>
    <script src="{{URL::asset('assets/js/chart.flot.sampledata.js')}}"></script>
    <!--Internal Apexchart js-->
    <script src="{{URL::asset('assets/js/apexcharts.js')}}"></script>
    <!-- Internal Map -->
    <script src="{{URL::asset('assets/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
    <script src="{{URL::asset('assets/js/modal-popup.js')}}"></script>
    <!--Internal  index js -->
    <script src="{{URL::asset('assets/js/index.js')}}"></script>
    <script src="{{URL::asset('assets/js/jquery.vmap.sampledata.js')}}"></script>
@endsection
