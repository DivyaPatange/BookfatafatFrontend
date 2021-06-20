@extends('user.user_layout.main')
@section('title', 'Services')
@section('page_title', 'Services')
@section('customcss')
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<style>
.error{
    color:red;
}
</style>
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                Services
                </h2>
            </div>
            <div class="body">
                <div class="row">
                    @foreach($services as $s)
                    <div class="col-md-3">
                        <div class="card">
                            <div class="header">
                                <img src="https://admin.bookfatafat.com/ServiceImg/{{ $s->service_img }}" width="100%" alt="" style="max-height:157px;">
                            </div>
                            <div class="body text-center">
                                <p>{{ $s->service_name }}</p>
                                <p>{{ $s->service_cost }}</p>
                                <a href="{{ route('book-service.show', $s->id) }}"><button type="button" class="btn bg-red waves-effect">Book Now</button></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('customjs')
<script>
</script>
@endsection