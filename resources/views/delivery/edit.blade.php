@extends("layouts.main_template_datatable")

@section('content')
<!-- Widgets -->
<div class="row clearfix">
  <!-- Task Info -->
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="card">

      <div class="header">
        <h2> Update Delivery </h2>
      </div>

      <div class="body">
        
        <div class="">
          <div class="well">
            <table class="table">
              <tbody>
                <tr> 
                  <th> Customer Name </th>
                  <td> {{ $delivery->customer_firstname }} {{ $delivery->customer_lastname }} </td>
                </tr>
                <tr> 
                  <th> Order Reference </th>
                  <td> {{ $delivery->name }} </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        
        <div class="form-group">
          <div class="form-line">
            <input type="text" class="form-control" placeholder="Customer Name" />
          </div>
        </div>
        
        <div class="form-group">
          <div class="form-line">
            <input type="text" class="form-control" placeholder="Username" />
          </div>
        </div>
        
        <div class="form-group">
          <div class="form-line">
            <input type="text" class="form-control" placeholder="Username" />
          </div>
        </div>
        
        <div class="form-group">
          <div class="form-line">
            <input type="text" class="form-control" placeholder="Username" />
          </div>
        </div>
        
         <div class="form-group">
          <div class="form-line">
            <textarea class="form-control" placeholder="Comments">
              
            </textarea>
          </div>
        </div>
        
        
      </div>

    </div>

  </div>
  <!-- #END# Task Info -->

</div>
@endsection