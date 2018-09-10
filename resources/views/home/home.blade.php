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
        
        <h2> {{ $report_title }} </h2>
        
        <hr>
        
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
                <input type="text" id="start_date" name="start_date" class="datepicker form-control" placeholder="Please choose start date ( inclusive )">
              </div>
            </div>
          </div>

          <div class="col-sm-6">
            <div class="form-group">
              <div class="form-line">
                <input type="text" id="end_date" name="end_date" class="datepicker form-control" placeholder="Please choose end date ( inclusive )">
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
  
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding-left: 8px; padding-right: 8px;">
    <div class="card">

      <div class="header">
        <h2> Sales Today  <a href="{{url("dashboard/fullfillment")}}" class="btn btn-primary btn-xs pull-right hidden"> View More </a> </h2>
      </div>

      <div style="margin:8px;">
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
                <td> {{ number_format($sales_today["All Orders"])  }} </td>
                <td> {{ number_format($sales_today["Gross Amount"])  }} </td>
                <td> {{ number_format($sales_today["Paid Orders"])  }} </td>
                <td> {{ number_format($sales_today["Paid Total Inc Vat"]) }} </td>
                <td> {{ number_format($sales_today["Paid Total ex Vat"]) }} </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
  
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding-left: 8px; padding-right: 8px;">
    <div class="card">

      <div class="header">
        <h2> Paid Fullfillment Rate </h2>
      </div>

      <div style="margin:8px;">
        
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
                <td> {{ number_format($fulfillment_rate["All Orders"])  }} </td>
                <td> {{ number_format($fulfillment_rate["Cancelled"])  }} </td>
                <td> {{ number_format($fulfillment_rate["CooD"])  }} </td>
                <td> {{ number_format($fulfillment_rate["CooD Not Cancelled"])  }} </td>
                <td> {{ number_format($fulfillment_rate["Paid Fullfilled Orders"])  }} </td>
                <td> {{ number_format($fulfillment_rate["Fullfillment Rate"])  }} </td>
              </tr>
            </tbody>
          </table>
          
        </div>
      </div>
    </div>

  </div>
  
  <!-- Task Info -->
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding-left: 8px; padding-right: 8px;">
    <div class="card">

      <div class="header">
        <h2> Pending Orders 
        </h2>
      </div>

      <div style="margin:8px;">
        <div class="table-responsive">
          
          <table class="table table-bordered">
            <tbody>
              <tr>
                <th> Number Of Orders </th>
                <th> Total Inc VAT </th>
                <th> Total Ex VAT </th>
              </tr>
              <tr>
                <td> {{ number_format($pending_orders["Number of Orders"])  }} </td>
                <td> {{ number_format($pending_orders["Total Inc VAT"])  }} </td>
                <td> {{ number_format($pending_orders["Total Ex VAT"])  }} </td>
              </tr>
            </tbody>
          </table>
          
        </div>
      </div>
      
    </div>
  </div>
  
  <!-- #END# Task Info -->
  <!-- Browser Usage -->
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding-left: 8px; padding-right: 8px;">
    <div class="card">

      <div class="header">
        <h2> Paid Sales <a href="{{url("dashboard/paidsalesamount")}}" class="btn btn-primary btn-xs pull-right hidden"> View More </a> </h2>
      </div>

      <div style="margin:8px;">
        <div class="table-responsive">
          
          <table class="table table-bordered">
            <tbody>
              <tr>
                <th> Number Of Orders </th>
                <th> Total Inc VAT </th>
                <th> Total Ex VAT </th>
              </tr>
              <tr>
                <td> {{ number_format($paid_sales["Number of Orders"])  }} </td>
                <td> {{ number_format($paid_sales["Total Sales Inc VAT"])  }} </td>
                <td> {{ number_format($paid_sales["Total Sales Ex VAT"])  }} </td>
              </tr>
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>
  <!-- #END# Browser Usage -->
</div>

<div class="row clearfix">
  <!-- Browser Usage -->
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding-left: 8px; padding-right: 8px;">
    <div class="card">

      <div class="header">
        <h2> Delivered orders   <a href="{{url("dashboard/deliveredorders")}}" class="btn btn-primary btn-xs pull-right hidden"> View More </a> </h2>
      </div>

      <div style="margin:8px;">
        <div class="table-responsive">
          
          <table class="table table-bordered">
            <tbody>
              <tr>
                <th> Number Of Orders </th>
                <th> Total Inc VAT </th>
                <th> Total Ex VAT </th>
              </tr>
              <tr>
                <td> {{ number_format($delivered_orders["Number of orders"])  }} </td>
                <td> {{ number_format($delivered_orders["Total Inc VAT"])  }} </td>
                <td> {{ number_format($delivered_orders["Order Ex Vat Total"])  }} </td>
              </tr>
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>
  
  <!-- Task Info -->
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding-left: 8px; padding-right: 8px;">
    <div class="card">

      <div class="header">
        <h2> Avr Basket ex VAT  <a href="{{url("dashboard/averagebasket")}}" class="btn btn-primary btn-xs pull-right hidden"> View More </a> </h2>
      </div>

      <div style="margin:8px;">
        <div class="table-responsive">
          
          <table class="table table-bordered">
            <tbody>
              <tr>
                <th> Total Sales Ex VAT </th>
                <th> Number Of Orders </th>
                <th> Average Basket Size </th>
              </tr>
              <tr>
                <td> {{ number_format($average_basket_size["Total Sales ex VAT"])  }} </td>
                <td> {{ number_format($average_basket_size["Number of Orders"])  }} </td>
                <td> {{ number_format($average_basket_size["Average Basket size"])  }} </td>
              </tr>
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>
  
</div>

<div class="row clearfix">
  <!-- Task Info -->
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding-left: 8px; padding-right: 8px;">
    <div class="card">

      <div class="header">
        <h2> Online Sales KES  <a href="{{url("dashboard/revenuedeliveredorders")}}" class="btn btn-primary btn-xs pull-right hidden"> View More </a> </h2>
      </div>

      <div style="margin:8px;">
        <div class="table-responsive">
          
          <table class="table table-bordered">
            <tbody>
              <tr>
                <th> Number Of Orders </th>
                <th> Total Inc VAT </th>
                <th> Total Ex VAT </th>
              </tr>
              <tr>
                <td> {{ number_format($onlinesales["Number of orders"])  }} </td>
                <td> {{ number_format($onlinesales["Total"])  }} </td>
                <td> {{ number_format($onlinesales["Total ex Vat"])  }} </td>
              </tr>
            </tbody>
          </table>

        </div>
      </div>
    </div>

  </div>
  <!-- #END# Task Info -->
  <!-- Browser Usage -->
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding-left: 8px; padding-right: 8px;">
    <div class="card">

      <div class="header">
        <h2> Offline Sales KES <a href="{{url("dashboard/offlinesales")}}" class="btn btn-primary btn-xs pull-right hidden"> View More </a> </h2>
      </div>

      <div style="margin:8px;">
        <div class="table-responsive">
          
          <table class="table table-bordered">
            <tbody>
              <tr>
                <th> Number Of Orders </th>
                <th> Total Inc VAT </th>
                <th> Total Ex VAT </th>
              </tr>
              <tr>
                <td> {{ number_format($offlinesales["Number of orders"])  }} </td>
                <td> {{ number_format($offlinesales["Total Inc Vat"])  }} </td>
                <td> {{ number_format($offlinesales["Total ex Vat"])  }} </td>
              </tr>
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>
  <!-- #END# Browser Usage -->
</div>

<div class="row clearfix">
  <!-- Task Info -->
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding-left: 8px; padding-right: 8px;">
    <div class="card">

      <div class="header">
        <h2> Untagged Staff sales KES <a href="{{url("dashboard/onlinesales")}}" class="btn btn-primary btn-xs pull-right hidden"> View More </a> </h2>
      </div>

      <div style="margin:8px;">
        <div class="table-responsive">
          
          <table class="table table-bordered">
            <tbody>
              <tr>
                <th> Number Of Orders </th>
                <th> Total Inc VAT </th>
                <th> Total Ex VAT </th>
              </tr>
              <tr>
                <td> {{ number_format($untaggedsales["order_count_summation"])  }} </td>
                <td> {{ number_format($untaggedsales["order_total_summation"])  }} </td>
                <td> {{ number_format($untaggedsales["ex_vat_total"])  }} </td>
              </tr>
            </tbody>
          </table>

        </div>
      </div>
    </div>

  </div>
  <!-- #END# Task Info -->
  <!-- Browser Usage -->
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding-left: 8px; padding-right: 8px;">
    <div class="card">

      <div class="header">
        <h2> New vs Returning Customers <a href="{{url("dashboard/pendingorders")}}" class="btn btn-primary btn-xs pull-right hidden"> View More </a> </h2>
      </div>

      <div style="margin:8px;">
        <div class="table-responsive">
          
          <table class="table table-bordered">
            <tbody>
              <tr>
                <th> All Customers </th>
                <th> New Customers </th>
                <th> Returning Customers </th>
              </tr>
              <tr>
                <td> {{ number_format($newvsreturning["All Customers"])  }} </td>
                <td> {{ number_format($newvsreturning["New Customers"])  }} </td>
                <td> {{ number_format($newvsreturning["Returning Customers"])  }} </td>
              </tr>
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>
  <!-- #END# Browser Usage -->
</div>

<div class="row clearfix">
  <!-- Task Info -->
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding-left: 8px; padding-right: 8px;">
    <div class="card">

      <div class="header">
        <h2> Breakdown Financial Status  <a href="{{url("dashboard/salesperstaff")}}" class="btn btn-primary btn-xs pull-right hidden"> View More </a> </h2>
      </div>

      <div style="margin:8px;">
        <div class="table-responsive">
          
          <table class="table table-bordered">
            <tbody>
              <tr>
                <th> Financial </th>
                <th> Number of Orders </th>
                <th> Total Ex VAT </th>
              </tr>
              
              @foreach($financial_breakdown as $financial)
              <tr>
                <td> {{ $financial["name"]  }} </td>
                <td> {{ number_format($financial["order_count"])  }} </td>
                <td> {{ number_format($financial["total_ex_vat"])  }} </td>
              </tr>
              @endforeach
              
            </tbody>
          </table>

        </div>
      </div>
    </div>

  </div>
  <!-- #END# Task Info -->
  <!-- Browser Usage -->
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding-left: 8px; padding-right: 8px;">
    <div class="card">
      <div class="header">
        <h2> Breakdown Fulfillment status  <a href="{{url("dashboard/salesperstaff")}}" class="btn btn-primary btn-xs pull-right hidden"> View More </a> </h2>
      </div>
      <div style="margin:8px;">        
        <div class="table-responsive">          
          <table class="table table-bordered">
            <tbody>
              <tr>
                <th> Fulfillment </th>
                <th> Number of Orders </th>
                <th> Total Ex VAT </th>
              </tr>
              @foreach($fullfillment_breakdown as $fullfillment)
              <tr>
                <td> {{ ($fullfillment["name"])  }} </td>
                <td> {{ number_format($fullfillment["order_count"])  }} </td>
                <td> {{ number_format($fullfillment["total_ex_vat"])  }} </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- #END# Browser Usage -->
</div>

<div class="row clearfix">
  <!-- Task Info -->
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding-left: 8px; padding-right: 8px;">
    <div class="card">

      <div class="header">
        <h2> Sales Per Staff - Paid Fulfilled
        </h2>
      </div>

      <div style="margin:8px;">
        <div class="table-responsive">
          
          <table class="table table-bordered">
            <tbody>
              <tr>
                <th> Staff </th>
                <th> Number of Orders </th>
                <th> Total Ex VAT </th>
              </tr>
              
              @foreach($salesperstaff as $sales)
              <tr>
                <td> {{ ($sales["name"])  }} </td>
                <td> {{ number_format($sales["order_count"])  }} </td>
                <td> {{ ($sales["total_ex_vat"]) > 1 ? number_format($sales["total_ex_vat"]) : "-" }} </td>
              </tr>
              @endforeach
              
            </tbody>
          </table>

        </div>
      </div>
    </div>

  </div>
  <!-- #END# Task Info -->
  <!-- Browser Usage -->
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding-left: 8px; padding-right: 8px;">
    <div class="card">

      <div class="header">
        <h2> 
          Pending Deliveries
        </h2>
      </div>

      <div style="margin:8px;">
        <div class="table-responsive">
          
          <table class="table table-bordered">
            <tbody>
              <tr>
                <th> Staff </th>
                <th> Number of Orders </th>
                <th> Total Ex VAT </th>
              </tr>
              
              @foreach($deliveriesperstaff as $sales)
              <tr>
                <td> {{ ($sales["name"])  }} </td>
                <td> {{ number_format($sales["order_count"])  }} </td>
                <td> {{ ($sales["total_ex_vat"]) > 1 ? number_format($sales["total_ex_vat"]) : "-" }} </td>
              </tr>
              @endforeach
              
              
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>
  <!-- #END# Browser Usage -->
</div>

@endsection