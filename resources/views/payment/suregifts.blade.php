@extends("layouts.main_template_datatable")

@section('content')
<!-- Widgets -->
<div class="row clearfix">
  <!-- Task Info -->
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="card">

      <div class="header">
        <h2> Check Suregifts Voucher Validity </h2>
      </div>

      <div class="body">
        <div class="">
          <form action="{{url('payment/suregifts')}}" method="POST">
            @csrf
            <div class="form-group">
              <div class="form-line">
                <input type="text" name="voucher_code" class="form-control" placeholder="Voucher Code" required />
              </div>
            </div>

            <div class="form-group">
              <button class="btn btn-primary"> Check Voucher Validity </button>
            </div>
          </form>
        </div>
      </div>

    </div>

  </div>
  <!-- #END# Task Info -->

</div>
@endsection