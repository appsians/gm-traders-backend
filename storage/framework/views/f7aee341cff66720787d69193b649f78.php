<style>
.table-responsive {
    -webkit-overflow-scrolling: touch;
    overflow-x: auto !important;
}
div.table-responsive>div.dataTables_wrapper>div.row>div[class^=col-]:first-child {
  
    overflow-x: auto;
    
}


table th, .datepicker table th, .table td, .datepicker table td {
    text-align: center;
    white-space: nowrap;
}
</style>


<?php $__env->startSection('content'); ?>



<div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            
                                 <h6 style="
    font-size: 20px; 
    
    font-weight: bold; 
   
    padding:10px 15px;
    border-radius:6px;
    margin-top:50px;
    color:#2c3e50;
">
    Pending Orders
</h6>
                            <h6 class="card-title"></h6>
                            <p class="text-muted mb-3"> <code></code></p>
                            <div class="table-responsive pt-3">
                                <table  id="dataTableExample" class="table">
                                    <thead>


                                        <tr>
                                            <th>#</th>
                                            <th>Order_id</th>
                                            <th>Name</th>
                                            <th>Location</th>
                                            <th>Place_Date</th>
                                         
                                            <th>Amount</th>
                                            <th>Remaning</th>
                                            <th>Status</th>
                                         
                                        </tr>

                                    </thead>
                                    <tbody>
                                            <?php $__currentLoopData = $Orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            	<td><?php echo e($loop->iteration); ?></td>
                                            <td><?php echo e($order->order_id); ?></td>
                                            <td>


                                                <?php echo e($order->name); ?>

                                            </td>
                                            <td><?php echo e($order->location); ?></td>
                                            <td><?php echo e($order->placed_date); ?></td>
                                         
                                            <td><?php echo e($order->amount_paid); ?></td>
                                            <td><?php echo e($order->amount_remaining); ?></td>
                                            
                                                <td><?php echo e($order->status); ?></td>



                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>





            <!-- Edit Modal -->

    <?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\chsan\Downloads\public_html (1)\public_html\resources\views/Admin/Orders/pending_orders.blade.php ENDPATH**/ ?>