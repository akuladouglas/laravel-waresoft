@extends("layouts.main_template")

@section('content')
<!-- Widgets -->
            <div class="block-header">
                <h2> Deliveries </h2>
            </div>

            <legend></legend>
            
            <div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                      
                      <div class="header">
                        <h2> Deliveries List  </h2>
                      </div>
                      
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered dashboard-task-infos">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Customer</th>
                                            <th>Amount</th>
                                            <th>Date Made</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>John Doe</td>
                                            <td><?php echo "150";?></td>
                                            <td><?php echo date("Y-m-d"); ?></td>
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
