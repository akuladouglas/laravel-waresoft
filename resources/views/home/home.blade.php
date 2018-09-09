@extends("layouts.main_template_select")

@section('content')
<!-- Widgets -->
<div class="block-header">
  <h2> Dashboard </h2>
</div>

<div class="row clearfix">
  <div class="col-lg-12">
    <div class="card">

      <div class="header">
        <h2>
          Select Period
        </h2>
      </div>

      <div class="body">
        <div class="row clearfix">
          
          <form action="{{ url('dashboard/getinfo') }}" method="post">
          
          @csrf
          
          <div class="col-md-12 hidden">
            <div class="form-group">
              <select class="form-control">
                <option value="Today"> Today </option>
                <option value="Yesterday"> Yesterday </option>
                <option value="Last 7 Days"> Last 7 Days </option>
                <option value="Last 14 Days"> Last 14 Days </option>
                <option value="Last 30 Days"> Last 30 Days </option>
                <option value="This Week"> This Week </option>
                <option value="Last Week"> Last Week </option>
                <option value="This Month"> This Month </option>
                <option value="Last Month"> Last Month </option>
                <option value="Custom Range"> Custom Range </option>
              </select>
            </div>
          </div>

          <div class="col-sm-6">
            <div class="form-group">
              <div class="form-line">
                <input type="text" id="start_date" name="start_date" class="datepicker form-control" placeholder="Please choose start date inclusive">
              </div>
            </div>
          </div>

          <div class="col-sm-6">
            <div class="form-group">
              <div class="form-line">
                <input type="text" id="end_date" name="end_date" class="datepicker form-control" placeholder="Please choose end date inclusive">
              </div>
            </div>
          </div>

          <div class="col-sm-12">

            <button type="submit" class="btn btn-primary btn-lg">
              Filter Sales Report
            </button>

          </div>
          
         </form>
          
        </div>
      </div>
    </div>
  </div>
</div>

<legend></legend>

<div class="row clearfix">
  
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
    <div class="card">

      <div class="header">
        <h2> Sales Today  <a href="{{url("dashboard/fullfillment")}}" class="btn btn-primary btn-xs pull-right hidden"> View More </a> </h2>
      </div>

      <div class="body">
        <div class="table-responsive">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <th> All Orders </th>
                <th> Gross Amount </th>
                <th> Paid Orders </th>
                <th> Paid Total Inc Vat </th>
                <th> Paid Total Ex Vat </th>
              </tr>
              <tr>
                <td> {{ $sales_today["All Orders"]  }} </td>
                <td> {{ $sales_today["Gross Amount"]  }} </td>
                <td> {{ $sales_today["Paid Orders"]  }} </td>
                <td> {{ $sales_today["Paid Total Inc Vat"]  }} </td>
                <td> {{ $sales_today["Paid Total ex Vat"]  }} </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
  
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
    <div class="card">

      <div class="header">
        <h2> Paid Fullfillment Rate </h2>
      </div>

      <div class="body">
        <div class="table-responsive">
          
          <table class="table table-bordered">
            <tbody>
              <tr>
                <th> All Orders </th>
                <th> Cancelled </th>
                <th> CooD </th>
                <th> CooD Not Cancelled </th>
                <th> Paid Fullfilled </th>
                <th> Fullfilment Rate </th>
              </tr>
              <tr>
                <td> {{ $sales_today["All Orders"]  }} </td>
                <td> {{ $sales_today["Gross Amount"]  }} </td>
                <td> {{ $sales_today["Paid Orders"]  }} </td>
                <td> {{ $sales_today["Paid Total Inc Vat"]  }} </td>
                <td> {{ $sales_today["Paid Total ex Vat"]  }} </td>
                <td> {{ $sales_today["Paid Total ex Vat"]  }} </td>
              </tr>
            </tbody>
          </table>
          
        </div>
      </div>
    </div>

  </div>
  
  <!-- Task Info -->
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
    <div class="card">

      <div class="header">
        <h2> Fullfillment Rate  <a href="{{url("dashboard/fullfillment")}}" class="btn btn-primary btn-xs pull-right hidden"> View More </a> </h2>
      </div>

      <div class="body">
        <div class="table-responsive">

        </div>
      </div>
    </div>

  </div>
  <!-- #END# Task Info -->
  <!-- Browser Usage -->
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
    <div class="card">

      <div class="header">
        <h2> Paid Sales Amount   <a href="{{url("dashboard/paidsalesamount")}}" class="btn btn-primary btn-xs pull-right hidden"> View More </a> </h2>
      </div>

      <div class="body">
        <div class="table-responsive">

        </div>
      </div>
    </div>
  </div>
  <!-- #END# Browser Usage -->
</div>

<div class="row clearfix">
  <!-- Task Info -->
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
    <div class="card">

      <div class="header">
        <h2> Avr Basket ex VAT  <a href="{{url("dashboard/averagebasket")}}" class="btn btn-primary btn-xs pull-right hidden"> View More </a> </h2>
      </div>

      <div class="body">
        <div class="table-responsive">

        </div>
      </div>
    </div>

  </div>
  <!-- #END# Task Info -->

  <!-- Browser Usage -->
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
    <div class="card">

      <div class="header">
        <h2> Delivered orders   <a href="{{url("dashboard/deliveredorders")}}" class="btn btn-primary btn-xs pull-right hidden"> View More </a> </h2>
      </div>

      <div class="body">
        <div class="table-responsive">

        </div>
      </div>
    </div>
  </div>
  <!-- #END# Browser Usage -->
</div>

<div class="row clearfix">
  <!-- Task Info -->
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
    <div class="card">

      <div class="header">
        <h2> Revenue ex VAT for Delivered orders  <a href="{{url("dashboard/revenuedeliveredorders")}}" class="btn btn-primary btn-xs pull-right hidden"> View More </a> </h2>
      </div>

      <div class="body">
        <div class="table-responsive">

        </div>
      </div>
    </div>

  </div>
  <!-- #END# Task Info -->
  <!-- Browser Usage -->
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
    <div class="card">

      <div class="header">
        <h2> Offline Sales KES <a href="{{url("dashboard/offlinesales")}}" class="btn btn-primary btn-xs pull-right hidden"> View More </a> </h2>
      </div>

      <div class="body">
        <div class="table-responsive">

        </div>
      </div>
    </div>
  </div>
  <!-- #END# Browser Usage -->
</div>

<div class="row clearfix">
  <!-- Task Info -->
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
    <div class="card">

      <div class="header">
        <h2> Online sales KES <a href="{{url("dashboard/onlinesales")}}" class="btn btn-primary btn-xs pull-right hidden"> View More </a> </h2>
      </div>

      <div class="body">
        <div class="table-responsive">

        </div>
      </div>
    </div>

  </div>
  <!-- #END# Task Info -->
  <!-- Browser Usage -->
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
    <div class="card">

      <div class="header">
        <h2> Number of Pending orders   <a href="{{url("dashboard/pendingorders")}}" class="btn btn-primary btn-xs pull-right hidden"> View More </a> </h2>
      </div>

      <div class="body">
        <div class="table-responsive">

        </div>
      </div>
    </div>
  </div>
  <!-- #END# Browser Usage -->
</div>

<div class="row clearfix">
  <!-- Task Info -->
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
    <div class="card">

      <div class="header">
        <h2> Sales ex VAT MTD per Staff  <a href="{{url("dashboard/salesperstaff")}}" class="btn btn-primary btn-xs pull-right hidden"> View More </a> </h2>
      </div>

      <div class="body">
        <div class="table-responsive">

        </div>
      </div>
    </div>

  </div>
  <!-- #END# Task Info -->
  <!-- Browser Usage -->
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
    <div class="card">
      <div class="header">
        <h2> Pending orders ex VAT per Staff  <a href="{{url("dashboard/salesperstaff")}}" class="btn btn-primary btn-xs pull-right hidden"> View More </a> </h2>
      </div>
      <div class="body">
        <div class="table-responsive">

        </div>
      </div>
    </div>
  </div>

  <!-- #END# Browser Usage -->
</div>

<div class="row clearfix">
  <!-- Task Info -->
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
    <div class="card">

      <div class="header">
        <h2> Number of orders today  <a href="{{url("dashboard/orderstoday")}}" class="btn btn-primary btn-xs pull-right hidden"> View More </a> </h2>
      </div>

      <div class="body">
        <div class="table-responsive">

        </div>
      </div>
    </div>

  </div>
  <!-- #END# Task Info -->
  <!-- Browser Usage -->
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
    <div class="card">

      <div class="header">
        <h2> Sales today ex VAT  <a href="{{url("dashboard/salestoday")}}" class="btn btn-primary btn-xs pull-right hidden"> View More </a> </h2>
      </div>

      <div class="body">
        <div class="table-responsive">

        </div>
      </div>
    </div>
  </div>
  <!-- #END# Browser Usage -->
</div>

@endsection
