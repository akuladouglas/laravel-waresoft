@extends("layouts.main_template_select")

@section('content')
<!-- Widgets -->
<div class="block-header">
  <h2> Dashboard </h2>
</div>

<div class="row clearfix">
  <div class="col-lg-12" style="padding-left: 8px; padding-right: 8px;">
    <div class="card" style="margin-bottom: 8px;">

      <div class="header">
        <h4> {{ $report_title }} </h4>
      </div>

      <div class="body">
        <div class="row clearfix">
          
          <form action="{{ url('dashboard/getinfo') }}" method="post">
          
          @csrf

          <div class="col-sm-4">
            <div class="form-group">
              <div class="form-line">
                <input required type="text" id="start_date" name="start_date" class="datepicker form-control" placeholder="Please choose start date ( inclusive )">
              </div>
            </div>
          </div>

          <div class="col-sm-4">
            <div class="form-group">
              <div class="form-line">
                <input required type="text" id="end_date" name="end_date" class="datepicker form-control" placeholder="Please choose end date ( inclusive )">
              </div>
            </div>
          </div>
          
          <div class="col-sm-4">
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
        <h2>   
          Sales Today
        </h2>
      </div>

      <div style="margin:8px;">
        <div class="table-responsive">
          <table class="table table-hover">
            <tbody>
              <tr style="font-size: 18px;">
                <th> {{ number_format($sales_today["All Orders"])  }} </th>
                <th> {{ number_format($sales_today["Gross Amount"])  }} </th>
                <th> {{ number_format($sales_today["Paid Orders"])  }} </th>
                <th> {{ number_format($sales_today["Paid Total Inc Vat"]) }} </th>
                <th> {{ number_format($sales_today["Paid Total ex Vat"]) }} </th>
              </tr>
              <tr style="font-size: 11px;">
                <td> All Orders </td>
                <td> Gross Amount </td>
                <td> Paid Orders </td>
                <td> Paid Total Inc Vat </td>
                <td> Paid Total Ex Vat </td>
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
          
          <table class="table table-hover">
            <tbody>
              
              <tr style="font-size: 18px;">
                <th> {{ number_format($fulfillment_rate["All Orders"])  }} </th>
                <th> {{ number_format($fulfillment_rate["Cancelled"])  }} </th>
                <th> {{ number_format($fulfillment_rate["CooD"])  }} </th>
                <!--<th> {{ number_format($fulfillment_rate["CooD Not Cancelled"])  }} </th>-->
                <th> {{ number_format($fulfillment_rate["Paid Fullfilled Orders"])  }} </th>
                <th> {{ number_format($fulfillment_rate["Fullfillment Rate"])  }}% </th>
              </tr>
              
              <tr style="font-size: 11px;">
                <td> All Orders </td>
                <td> Cancelled </td>
                <td> CooD </td>
                <!--<td> CooD Not Cancelled </td>-->
                <td> Paid Fullfilled </td>
                <td> Fullfilment Rate </td>
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
          
          <table class="table table-hover">
            <tbody>
              <tr style="font-size: 18px;">
                <th> {{ number_format($pending_orders["Number of Orders"])  }} </th>
                <th> {{ number_format($pending_orders["Total Inc VAT"])  }} </th>
                <th> {{ number_format($pending_orders["Total Ex VAT"])  }} </th>
              </tr>
              <tr style="font-size: 11px;">
                <td> Number Of Orders </td>
                <td> Total Inc VAT </td>
                <td> Total Ex VAT </td>
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
          
          <table class="table table-hover">
            <tbody>
              <tr style="font-size: 18px;">
                <th> {{ number_format($paid_sales["Number of Orders"])  }} </th>
                <th> {{ number_format($paid_sales["Total Sales Inc VAT"])  }} </th>
                <th> {{ number_format($paid_sales["Total Sales Ex VAT"])  }} </th>
              </tr>
              <tr style="font-size: 11px;">
                <td> Number Of Orders </td>
                <td> Total Inc VAT </td>
                <td> Total Ex VAT </td>
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
          
          <table class="table table-hover">
            <tbody>
              <tr style="font-size: 18px;">
                <th> {{ number_format($delivered_orders["Number of orders"])  }} </th>
                <th> {{ number_format($delivered_orders["Total Inc VAT"])  }} </th>
                <th> {{ number_format($delivered_orders["Order Ex Vat Total"])  }} </th>
              </tr>
              <tr style="font-size: 11px;">
                <td> Number Of Orders </td>
                <td> Total Inc VAT </td>
                <td> Total Ex VAT </td>
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
        <h2> Avr Basket Size ex VAT  <a href="{{url("dashboard/averagebasket")}}" class="btn btn-primary btn-xs pull-right hidden"> View More </a> </h2>
      </div>

      <div style="margin:8px;">
        <div class="table-responsive">
          
          <table class="table table-hover">
            <tbody>
              <tr style="font-size: 18px;">
                <th> {{ number_format($average_basket_size["Total Sales ex VAT"])  }} </th>
                <th> {{ number_format($average_basket_size["Number of Orders"])  }} </th>
                <th> {{ number_format($average_basket_size["Average Basket size"])  }} </th>
              </tr>
              <tr style="font-size: 11px;">
                <td> Total Sales Ex VAT </td>
                <td> Number Of Orders </td>
                <td> Average Basket Size </td>
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
          
          <table class="table table-hover">
            <tbody>
              
              <tr style="font-size: 18px;">
                <th> {{ number_format($onlinesales["Number of orders"])  }} </th>
                <th> {{ number_format($onlinesales["Total"])  }} </th>
                <th> {{ number_format($onlinesales["Total ex Vat"])  }} </th>
              </tr>
              
              <tr style="font-size: 11px;">
                <td> Number Of Orders </td>
                <td> Total Inc VAT </td>
                <td> Total Ex VAT </td>
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
          
          <table class="table table-hover">
            <tbody>
              
              <tr style="font-size: 18px;">
                <th> {{ number_format($offlinesales["Number of orders"])  }} </th>
                <th> {{ number_format($offlinesales["Total Inc Vat"])  }} </th>
                <th> {{ number_format($offlinesales["Total ex Vat"])  }} </th>
              </tr>
              
              <tr style="font-size: 11px;">
                <td> Number Of Orders </td>
                <td> Total Inc VAT </td>
                <td> Total Ex VAT </td>
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
          
          <table class="table table-hover">
            <tbody>
              <tr style="font-size: 18px;">
                <th> {{ number_format($untaggedsales["order_count_summation"])  }} </th>
                <th> {{ number_format($untaggedsales["order_total_summation"])  }} </th>
                <th> {{ number_format($untaggedsales["ex_vat_total"])  }} </th>
              </tr>
              
              <tr style="font-size: 11px;">
                <td> Number Of Orders </td>
                <td> Total Inc VAT </td>
                <td> Total Ex VAT </td>
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
          
          <table class="table table-hover">
            <tbody>
              <tr style="font-size: 18px;">
                <th> {{ number_format($newvsreturning["All Customers"])  }} </th>
                <th> {{ number_format($newvsreturning["New Customers"])  }} </th>
                <th> {{ number_format($newvsreturning["Returning Customers"])  }} </th>
              </tr>
              <tr style="font-size: 11px;">
                <td> All Customers </td>
                <td> New Customers </td>
                <td> Returning Customers </td>
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
          
          <table class="table table-hover">
            <tbody>
              <tr>
                <th> Status </th>
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
          <table class="table table-hover">
            <tbody>
              <tr>
                <th> Status </th>
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
          
          <table class="table table-hover">
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
          
          <table class="table table-hover">
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


<div class="row clearfix">
  <!-- Task Info -->
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding-left: 8px; padding-right: 8px;">
    <div class="card">

      <div class="header">
        <h2> 
          Untagged Sales Ids
        </h2>
      </div>

      <div style="margin:8px;">
        <div class="table-responsive">
          
          <table class="table table-bordered">
            <tbody>
              <tr>
                <th> Order Ids </th>
              </tr>
              <tr>
                <td> 
                @foreach($untaggedsalesids as $key => $id)
                  {{ $key == 0 ? "" : " ," }} {{$id}}
                @endforeach
                </td>
              </tr>
            </tbody>
          </table>

        </div>
      </div>
    </div>

  </div>
  <!-- #END# Task Info -->
  <!-- Browser Usage -->
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 hidden" style="padding-left: 8px; padding-right: 8px;">
    <div class="card">

      <div class="header">
        <h2> 
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