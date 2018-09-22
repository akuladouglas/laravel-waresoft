@extends("layouts.pdf_template")

@section('content')

<div class="row clearfix">
  <!-- Task Info -->
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="card">

      @include('includes.notifications')

      <div class="header">
        <h2> Invoice  </h2>
      </div>

      <div class="body">
        <div class="table-responsive">
          <table class="table table-hover table-bordered dashboard-task-infos">
            <thead>
              <tr>
                <th> </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td> </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
  <!-- #END# Task Info -->

</div>
@endsection
