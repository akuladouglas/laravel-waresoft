@extends("layouts.main_template_datatable")

@section('content')
<!-- Widgets -->
<div class="row clearfix">
  <!-- Task Info -->
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="card">

      <div class="header">
        <h2> Rewards Sms List </h2>
      </div>

      <div class="body">

        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover dataTable js-exportable">
            <thead>
              <tr>
                <th>#</th>
                <th>Text</th>
                <th>Text</th>
                <th>Sent</th>
              </tr>
            </thead>
            <tbody>
              @foreach($sms as $text)
              <tr>
                <td> {{ $text->rewards_sms_id }} </td>
                <td> {{ $text->phone }} </td>
                <td> {{ $text->text }} </td>
                <td> {{ $text->sent ? "Yes" : "No" }} </td>
              </tr>
              @endforeach
            </tbody>
          </table>

          <ul class="pagination-sm text-center">
          </ul>

        </div>


      </div>

    </div>

  </div>
  <!-- #END# Task Info -->

</div>
@endsection