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
                <th>Order Made </th>
                <th>Dlvry. Date</th>
                <th>Customer </th>
                <th>Order </th>
                <th>Phone </th>
                <th>Price </th>
                <th>Fin. Status </th>
                <th>Invoice</th>
                <th>Rider </th>
                <th>Dispatched </th>
                <th>Delivered</th>
                <th>Payment</th>
                <th>Stock</th>
                <th>Returns</th>
                <th></th>
                <th>Bulk</th>
              </tr>
            </thead>
            <tbody>
              @foreach($deliveries as $key => $order)
              <tr>
                <td> {{ date("y/m/d", strtotime($order->shopify_created_at)) }} </td>
                <td> {{ date("y/m/d", strtotime($order->created_at)) }} </td>
                <td> {{ $order->customer_firstname }} {{ $order->customer_lastname }} </td>
                <td> <a href="{{url("order/view/{$order->id}")}}"> {{ $order->name }} </a> </td>
                <td> {{ $order->customer_phone }} </td>
                <td> {{ number_format($order->total_price) }} </td>
                <td> {{ $order->financial_status }} </td>
                
                <td> <a class="btn btn-primary btn-xs" href="{{url("delivery/download-invoice/".$order->order_id)}}"> <small> Pdf </small> </a> </td>
                <td> 
                  <!--modal button-->
                  @if($order->rider_id)
                  <small style="font-size: 10px;"> {{ $riders_array[$order->rider_id] }} </small>
                      <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#riderModal-{{ $order->order_id }}">
                        <small> Change Rider </small>
                      </button>                
                  @else
                    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#riderModal-{{ $order->order_id }}">
                       <small> Assign Rider </small>
                    </button>
                  @endif
                  
                  <!--end modal button-->
                  
                  <!--modal-->
                  
                  <!-- Modal -->
                  
                    <div class="modal fade" id="riderModal-{{ $order->order_id }}" tabindex="-1" role="dialog" aria-labelledby="riderModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          
                          <div class="modal-header">
                            <h5 class="modal-title" id="riderModalLabel"> Assign Rider to this delivery </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          
                          <form action="{{ url("delivery/assign-rider") }}" method="post" enctype="multipart/form-data">
                            
                          <div class="modal-body">
                            @csrf
                                
                            <input name="order_id" type="hidden" value="{{ $order->id }}">
                                              
                            <select name="rider_id" id="rider_id" class="form-control">
                              <option value=""> -- select rider below -- </option>
                              @foreach($riders as $rider)
                              <option value="{{ $rider->rider_id }}"> {{ $rider->rider_name }} </option>
                              @endforeach
                            </select>
                            
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary"> Save Rider </button>
                          </div>
                            
                          </form>
                          
                        </div>
                      </div>
                    </div>
                  <!--end modal-->                  
                </td>
                
                <td>
                  @if($order->dispatched)
                  <span> <small> <i class="material-icons" style="font-size: 12px;">check</i> {{ date("d/m/y", strtotime($order->dispatched_date)) }} </small> </span>
                  @else
                  <a onclick="return confirm('Dispatch Order. Proceed ?')" class="btn btn-xs btn-primary" href="{{ url("delivery/mark-dispatched/{$order->order_id}") }}"> <small> Dispatch </small> </a>
                  @endif
                </td>
                
                <td> 
                   <!--<a onclick="return confirm('Mark this order as delivered. Proceed ?')" class="btn btn-primary btn-xs" href="{{ url("delivery/mark-delivered/".$order->id) }}"> Mark Delivered </a>-->
                  <!--modal button-->
                  @if($order->delivered)
                  <span> <small> <i class="material-icons" style="font-size: 14px;">check</i> {{ date("d/m/y", strtotime($order->delivery_date)) }} </small> </span>
                  @else 
                    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#deliveredModal">
                    <small style="font-size: 10px;"> Mark Delivered </small>
                    </button>
                  @endif
                  <!--end modal button-->
                  
                  <!--modal-->
                  
                  <!-- Modal -->
                  
                    <div class="modal fade" id="deliveredModal" tabindex="-1" role="dialog" aria-labelledby="deliveryModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="deliveryModalLabel"> Update this Order Delivered </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          
                          <form action="{{ url("delivery/mark-delivered") }}" method="post" enctype="multipart/form-data">
                            
                          <div class="modal-body">
                            @csrf
                                
                            <input name="order_id" type="hidden" value="{{ $order->id }}">
                                              
                            <select name="delivery_partner_id" id="delivery_partner_id" class="form-control">
                              <option value="null" selected > No Delivery Partner </option>
                              @foreach($delivery_partners as $partner)
                                <option value="{{ $partner->delivery_partner_id }}"> {{ $partner->name }} </option>
                              @endforeach
                            </select>
                            
                          </div>
                            
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary"> Update Delivery Information </button>
                          </div>
                            
                          </form>
                          
                        </div>
                      </div>
                    </div>
                  <!--end modal-->
                  
                </td>
                
                <td> 
                  <!--modal button-->
                  @if(!$order->paid)
                    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#deliveryModal-{{ $key }}">
                      <small style="font-size: 10px;"> Update Payment </small>
                    </button>
                  @else
                    <span> <small> <i class="material-icons" style="font-size: 12px;">check</i> {{ date("d/m/y", strtotime($order->paid_date)) }} </small> </span>
                  @endif
                  <!--end modal button-->
                  
                    <div class="modal fade" id="deliveryModal-{{$key}}" tabindex="-1" role="dialog" aria-labelledby="deliveryModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="deliveryModalLabel"> Mark delivered and update payment status </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          
                          <form action="{{ url("delivery/mark-paid") }}" method="post" enctype="multipart/form-data">
                            
                          <div class="modal-body">
                            
                            @csrf
                            
                            <input name="order_id" type="hidden" value="{{ $order->id }}">
                            
                            <select name="payment_method_id" id="rider_id" class="form-control">
                              <option value=""> -- select payment method below -- </option>
                              @foreach($payment_methods as $payment_method)
                              <option value="{{ $payment_method->payment_method_id }}"> {{ $payment_method->name }} </option>
                              @endforeach
                            </select>
                            
                          </div>
                            
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary"> Save Payment method </button>
                          </div>
                            
                          </form>
                          
                        </div>
                        
                      </div>
                    </div>
                  <!--end modal-->
                </td>
                
                <td> 
                  @if(!$order->stock_commited)
                    <a onclick="return confirm('Update stock from this delivery. Proceed ?')" class="btn btn-primary btn-xs" href="{{ url("delivery/commit-stock/".$order->id) }}"> <small> Commit Stock </small> </a>
                  @else
                  <span> <small> <i class="material-icons" style="font-size: 12px;">check</i> </small> </span>
                  @endif
                </td>
                
                <td>
                  
                </td>
                
                <td> 
                  <a href="{{url("delivery/edit/{$order->id}")}}" class="btn btn-xs btn-default"> <small> Edit </small> </a> 
                </td>
                
                <td>
                  <input type="checkbox" name="bulk_selected[]" id="bulk_selected" value="{{ $order->order_id }}" />
                </td>
                
              </tr>
              @endforeach
            </tbody>
            
            <tfoot>
              <td colspan="8"> Bulk Actions </td>
              
              <td> 
              <!--bulk change rider -->
              <form action="">
                <button type="submit" class="btn btn-xs btn-success"> Assign Rider </button>
              </form>
              </td>
              
              <td> 
              <!--bulk dispatch-->
              <form action="">
                <button type="submit" class="btn btn-xs btn-success"> Dispatch </button>
              </form>
              </td>
              
              <td>
              <!--bulk deliver--> 
              <form action="">
                <button type="submit" class="btn btn-xs btn-success"> Mark Delivered </button>
              </form>
              </td>
              
              <td> 
              <!--bulk payment-->
              <form action="">
                <button type="submit" class="btn btn-xs btn-success"> Mark Paid </button>
              </form>
              </td>
              
              <td> 
              <!--bulk stock-->
              <form action="">
                <button type="submit" class="btn btn-xs btn-success"> Commit Stock </button>
              </form>
              </td>
              
              <td colspan="2"> </td>
            </tfoot>
            
          </table>
        </div>
      </div>
    </div>

  </div>
  <!-- #END# Task Info -->

</div>
@endsection
