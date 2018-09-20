@extends("layouts.main_template_select")

@section('content')

<div class="row clearfix">
  <!-- Task Info -->
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="card">

      @include('includes.notifications')

      <div class="header">
        <h2> Deliveries List  </h2>
      </div>

      <div class="body">
        <div class="table-responsive">
          <table class="table table-hover table-bordered dashboard-task-infos">
            <thead>
              <tr>
                <th>Date Made </th>
                <th>Customer </th>
                <th>Order </th>
                <th>Phone </th>
                <th>Total Price </th>
                <th>Financial Status </th>
                <th>Rider </th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach($deliveries as $order)
              <tr>
                <td> {{ date("y/m/d", strtotime($order->shopify_created_at)) }} </td>
                <td> {{ $order->customer_firstname }} {{ $order->customer_lastname }} </td>
                <td> <a href="{{url("order/view/{$order->id}")}}"> {{ $order->name }} </a> </td>
                <td> {{ $order->customer_phone }} </td>
                <td> {{ $order->total_price }} </td>
                <td> {{ $order->financial_status }} </td>
                <td> 
                  <!--modal button-->
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#riderModal">
                    Assign Rider
                  </button>
                  <!--end modal button-->
                  
                  <!--modal-->
                  
                  <!-- Modal -->
                  
                    <div class="modal fade" id="riderModal" tabindex="-1" role="dialog" aria-labelledby="riderModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="riderModalLabel"> Assign Rider to this delivery </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            
                            <select class="form-control">
                              <option value=""> -- select rider below -- </option>
                              <option value="1"> Rider One </option>
                              <option value="2"> Rider Two </option>
                            </select>
                            
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary"> Save Rider </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  
                  <!--end modal-->
                  
                </td>
                <td> 
                 <a href="{{url("delivery/update/{$order->id}")}}" class="btn btn-xs btn-primary"> Edit Delivery </a> 
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
  <!-- #END# Task Info -->

</div>
@endsection
