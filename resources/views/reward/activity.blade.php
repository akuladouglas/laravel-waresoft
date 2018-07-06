@extends("layouts.main_template")

@section('content')
<!-- Widgets -->
            <div class="block-header">
                <h2> Activity </h2>
            </div>

            <legend></legend>
            
            <div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                      
                      <div class="header">
                        <h2> Activity List </h2>
                      </div>
                      
                        <div class="body">
                          
                          <ul class="pagination-sm text-center">
                                  {{ $activities->links() }}
                          </ul>
                          
                            <div class="table-responsive">
                                <table id="ordersTable" class="table table-hover table-bordered dashboard-task-infos">
                                    <thead>
                                        <tr>
                                            <th> # </th>
                                            <th>Customer</th>
                                            <th>Email</th>
                                            <th>Activity <br> Description</th>
                                            <th>Date Created </th>
                                            <th>Amount</th>
                                            <th>Orders Made</th>
                                            <th>Points Earned</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                          @foreach($activities as $activity)
                                           <tr>
                                               <td> {{ $activity->rewards_activity_id }} </td>
                                               <td> {{ $activity->firstName }}  {{ $activity->lastName }} </td>
                                               <td> {{ $activity->emailAddress }} </td>
                                               <th> {{ $activity->description }} </th>
                                               <td> {{ date("Y-m-d", strtotime($activity->createdAt)) }} </td>
                                               <td> {{ $activity->totalSpent }} </td>
                                               <td> {{ $activity->totalOrders }} </td>
                                               <td> {{ $activity->points }} </td>
                                           </tr>
                                          @endforeach
                                    </tbody>
                                </table>
                              
                                <ul class="pagination-sm text-center">
                                  {{ $activities->links() }}
                                </ul>
                              
                            </div>
                        </div>
                      
                      
                      
                    </div>
                  
                </div>
                <!-- #END# Task Info -->
                
            </div>
@endsection