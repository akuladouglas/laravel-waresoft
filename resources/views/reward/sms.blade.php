@extends("layouts.main_template")

@section('content')
<!-- Widgets -->
            <div class="block-header">
                <h2> Rewards Sms </h2>
            </div>

            <legend></legend>
            
            <div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                      
                      <div class="header">
                        <h2> Rewards Sms List </h2>
                      </div>
                      
                        <div class="body">
                          
                          <ul class="pagination-sm text-center">
                                  {{ $sms->links() }}
                          </ul>
                          
                            <div class="table-responsive">
                                <table id="ordersTable" class="table table-hover table-bordered dashboard-task-infos">
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
                          
                          <ul class="pagination-sm text-center">
                                  {{ $sms->links() }}
                          </ul>
                          
                        </div>
                      
                    </div>
                  
                </div>
                <!-- #END# Task Info -->
                
            </div>
@endsection