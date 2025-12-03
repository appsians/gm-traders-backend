<?php $__env->startSection('content'); ?>

<style>
    .stat-card {
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }
    .stat-card .card-title a {
        color: inherit;
        text-decoration: none;
        font-weight: 600;
    }
    .stat-card .card-title a:hover {
        color: #6571ff;
    }
    .recent-orders-card {
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    .orders-chart-card {
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
        cursor: pointer;
    }
    .badge-status {
        padding: 0.4em 0.8em;
        font-size: 0.75em;
        font-weight: 600;
    }
    .date-range-buttons .btn {
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
    }
    .chart-container {
        position: relative;
        height: 400px;
    }
    .view-all-link {
        color: #6571ff;
        text-decoration: none;
        font-weight: 500;
    }
    .view-all-link:hover {
        text-decoration: underline;
    }
</style>

<div class="page-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin mb-4">
        <div>
            <h4 class="mb-3 mb-md-0">Welcome to Dashboard</h4>
            <p class="text-muted">Overview of your business metrics</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow-1">
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">
                                    <a href="<?php echo e(route('all_Order')); ?>">All Orders</a>
                                </h6>
                                <div class="dropdown mb-2">
                                    <button class="btn p-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item d-flex align-items-center" href="<?php echo e(route('all_Order')); ?>"><i data-feather="eye" class="icon-sm me-2"></i> <span>View All</span></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2"><?php echo e($totalOrders); ?></h3>
                                    <div class="d-flex align-items-baseline">
                                        <p class="text-success">
                                            <span>Total orders</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-12 col-xl-7">
                                    <div id="customersChart" class="mt-md-3 mt-xl-0"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">
                                    <a href="<?php echo e(route('all_Order')); ?>">Pending Orders</a>
                                </h6>
                                <div class="dropdown mb-2">
                                    <button class="btn p-0" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <a class="dropdown-item d-flex align-items-center" href="<?php echo e(route('all_Order')); ?>"><i data-feather="eye" class="icon-sm me-2"></i> <span>View All</span></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2"><?php echo e($pendingOrders); ?></h3>
                                    <div class="d-flex align-items-baseline">
                                        <p class="text-warning">
                                            <span>Awaiting confirmation</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-12 col-xl-7">
                                    <div id="ordersChart" class="mt-md-3 mt-xl-0"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">
                                    <a href="<?php echo e(route('all_Order')); ?>">Complete Orders</a>
                                </h6>
                                <div class="dropdown mb-2">
                                    <button class="btn p-0" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                        <a class="dropdown-item d-flex align-items-center" href="<?php echo e(route('all_Order')); ?>"><i data-feather="eye" class="icon-sm me-2"></i> <span>View All</span></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2"><?php echo e($completedOrders); ?></h3>
                                    <div class="d-flex align-items-baseline">
                                        <p class="text-success">
                                            <span>Successfully completed</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-12 col-xl-7">
                                    <div id="growthChart" class="mt-md-3 mt-xl-0"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Stats Row -->
    <div class="row">
        <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow-1">
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">
                                    <a href="<?php echo e(url('trills/all')); ?>">All Trellis Materials</a>
                                </h6>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="mb-2"><?php echo e($user); ?></h3>
                                    <div class="d-flex align-items-baseline">
                                        <p class="text-info">
                                            <span>Total materials</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">
                                    <a href="<?php echo e(route('all_plant')); ?>">All Plants</a>
                                </h6>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="mb-2"><?php echo e($plants); ?></h3>
                                    <div class="d-flex align-items-baseline">
                                        <p class="text-success">
                                            <span>Total plants</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">
                                    <a href="<?php echo e(route('all_fruits')); ?>">All Fruits</a>
                                </h6>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="mb-2"><?php echo e($fruit); ?></h3>
                                    <div class="d-flex align-items-baseline">
                                        <p class="text-warning">
                                            <span>Total fruits</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Chart Section -->
    <div class="row mt-4">
        <div class="col-12 grid-margin stretch-card">
            <div class="card orders-chart-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="card-title mb-0">Orders Over Time</h6>
                        <div class="date-range-buttons">
                            <button type="button" class="btn btn-sm btn-outline-primary active" data-range="7">Last 7 Days</button>
                            <button type="button" class="btn btn-sm btn-outline-primary" data-range="30">Last 30 Days</button>
                            <button type="button" class="btn btn-sm btn-outline-primary" data-range="90">Last 90 Days</button>
                            <button type="button" class="btn btn-sm btn-outline-primary" data-range="custom" id="customRangeBtn">Custom Range</button>
                        </div>
                    </div>
                    <div id="customDateRange" class="mb-3" style="display: none;">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="startDate">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">End Date</label>
                                <input type="date" class="form-control" id="endDate">
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="button" class="btn btn-primary" id="applyCustomRange">Apply</button>
                            </div>
                        </div>
                    </div>
                    <div class="chart-container">
                        <div id="ordersTimeChart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="row mt-4">
        <div class="col-12 grid-margin stretch-card">
            <div class="card recent-orders-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="card-title mb-0">Recent Orders</h6>
                        <a href="<?php echo e(route('all_Order')); ?>" class="view-all-link">
                            View All Orders <i data-feather="arrow-right" class="icon-sm"></i>
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer Name</th>
                                    <th>Location</th>
                                    <th>Placed Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($order->order_id); ?></td>
                                    <td><?php echo e($order->name); ?></td>
                                    <td><?php echo e($order->location ?? '-'); ?></td>
                                    <td>
                                        <?php
                                            // Get raw attribute to bypass accessor
                                            $rawPlacedDate = $order->getRawOriginal('placed_date') ?? null;
                                        ?>
                                        <?php echo e($rawPlacedDate ? \Carbon\Carbon::parse($rawPlacedDate)->format('M d, Y') : '-'); ?>

                                    </td>
                                    <td>
                                        <?php
                                            // Get raw attribute to bypass accessor
                                            $rawAmountPaid = $order->getRawOriginal('amount_paid') ?? 0;
                                        ?>
                                        ₹<?php echo e(number_format($rawAmountPaid, 2)); ?>

                                    </td>
                                    <td>
                                        <?php
                                            $statusClass = 'bg-secondary';
                                            if($order->status === 'completed') $statusClass = 'bg-success';
                                            elseif($order->status === 'pending') $statusClass = 'bg-warning';
                                            elseif($order->status === 'cancelled') $statusClass = 'bg-danger';
                                        ?>
                                        <span class="badge badge-status <?php echo e($statusClass); ?>"><?php echo e(ucfirst($order->status ?? 'pending')); ?></span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info view-order-btn" data-id="<?php echo e($order->id); ?>" title="View Details">
                                            <i data-feather="eye" class="icon-sm"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="text-center">No recent orders found</td>
                                </tr>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Order Detail Modal -->
<div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderDetailModalLabel">Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="order-detail-body">
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Initialize feather icons
    if (typeof feather !== 'undefined') {
        feather.replace();
    }

    // Chart colors
    const colors = {
        primary: "#6571ff",
        secondary: "#7987a1",
        success: "#05a34a",
        info: "#66d1d1",
        warning: "#fbbc06",
        danger: "#ff3366",
        light: "#e9ecef",
        dark: "#060c17",
        muted: "#7987a1",
        gridBorder: "rgba(77, 138, 240, .15)",
        bodyColor: "#000",
        cardBg: "#fff"
    };

    // Fix existing charts in cards
    // Customers Chart (All Orders)
    if($('#customersChart').length) {
        var options1 = {
            chart: {
                type: "area",
                height: 60,
                sparkline: {
                    enabled: true
                }
            },
            series: [{
                name: 'Orders',
                data: [<?php echo e($totalOrders); ?>, <?php echo e($totalOrders); ?>, <?php echo e($totalOrders); ?>, <?php echo e($totalOrders); ?>, <?php echo e($totalOrders); ?>, <?php echo e($totalOrders); ?>, <?php echo e($totalOrders); ?>]
            }],
            stroke: {
                width: 2,
                curve: "smooth"
            },
            colors: [colors.primary],
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.1,
                    stops: [0, 100]
                }
            }
        };
        new ApexCharts(document.querySelector("#customersChart"), options1).render();
    }

    // Orders Chart (Pending Orders)
    if($('#ordersChart').length) {
        var options2 = {
            chart: {
                type: "bar",
                height: 60,
                sparkline: {
                    enabled: true
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 2,
                    columnWidth: "60%"
                }
            },
            colors: [colors.warning],
            series: [{
                name: '',
                data: [<?php echo e($pendingOrders); ?>, <?php echo e($pendingOrders); ?>, <?php echo e($pendingOrders); ?>, <?php echo e($pendingOrders); ?>, <?php echo e($pendingOrders); ?>, <?php echo e($pendingOrders); ?>, <?php echo e($pendingOrders); ?>]
            }]
        };
        new ApexCharts(document.querySelector("#ordersChart"), options2).render();
    }

    // Growth Chart (Completed Orders)
    if($('#growthChart').length) {
        var options3 = {
            chart: {
                type: "line",
                height: 60,
                sparkline: {
                    enabled: true
                }
            },
            series: [{
                name: '',
                data: [<?php echo e($completedOrders); ?>, <?php echo e($completedOrders); ?>, <?php echo e($completedOrders); ?>, <?php echo e($completedOrders); ?>, <?php echo e($completedOrders); ?>, <?php echo e($completedOrders); ?>, <?php echo e($completedOrders); ?>]
            }],
            stroke: {
                width: 2,
                curve: "smooth"
            },
            markers: {
                size: 0
            },
            colors: [colors.success]
        };
        new ApexCharts(document.querySelector("#growthChart"), options3).render();
    }

    // Orders Over Time Chart
    let ordersTimeChart;
    let currentRange = '7';

    function loadOrdersChart(range = '7', startDate = null, endDate = null) {
        const url = new URL("<?php echo e(route('dashboard.orders.chart.data')); ?>", window.location.origin);
        url.searchParams.append('range', range);
        if (startDate && endDate) {
            url.searchParams.append('start_date', startDate);
            url.searchParams.append('end_date', endDate);
        }

        $.ajax({
            url: url.toString(),
            type: "GET",
            success: function(response) {
                if (response.status && response.data) {
                    const data = response.data;
                    
                    if (ordersTimeChart) {
                        ordersTimeChart.destroy();
                    }

                    const options = {
                        chart: {
                            type: 'line',
                            height: 350,
                            toolbar: {
                                show: true
                            }
                        },
                        series: [{
                            name: 'Orders',
                            data: data.counts
                        }],
                        xaxis: {
                            categories: data.dates,
                            labels: {
                                rotate: -45,
                                style: {
                                    fontSize: '12px'
                                }
                            }
                        },
                        yaxis: {
                            title: {
                                text: 'Number of Orders'
                            }
                        },
                        stroke: {
                            width: 3,
                            curve: 'smooth'
                        },
                        colors: [colors.primary],
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0.7,
                                opacityTo: 0.3,
                                stops: [0, 100]
                            }
                        },
                        markers: {
                            size: 5,
                            hover: {
                                size: 7
                            }
                        },
                        tooltip: {
                            y: {
                                formatter: function(val) {
                                    return val + " orders";
                                }
                            }
                        },
                        grid: {
                            borderColor: colors.gridBorder,
                            strokeDashArray: 4
                        }
                    };

                    ordersTimeChart = new ApexCharts(document.querySelector("#ordersTimeChart"), options);
                    ordersTimeChart.render();
                }
            },
            error: function() {
                console.error('Failed to load chart data');
            }
        });
    }

    // Date range button handlers
    $('.date-range-buttons .btn').on('click', function() {
        $('.date-range-buttons .btn').removeClass('active');
        $(this).addClass('active');
        
        const range = $(this).data('range');
        currentRange = range;

        if (range === 'custom') {
            $('#customDateRange').slideDown();
        } else {
            $('#customDateRange').slideUp();
            loadOrdersChart(range);
        }
    });

    $('#applyCustomRange').on('click', function() {
        const startDate = $('#startDate').val();
        const endDate = $('#endDate').val();
        
        if (!startDate || !endDate) {
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Please select both start and end dates'
            });
            return;
        }

        if (new Date(startDate) > new Date(endDate)) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Start date must be before end date'
            });
            return;
        }

        loadOrdersChart('custom', startDate, endDate);
    });

    // Load initial chart
    loadOrdersChart('7');

    // View order details
    $(document).on('click', '.view-order-btn', function() {
        const orderId = $(this).data('id');
        loadOrderDetails(orderId);
    });

    function loadOrderDetails(orderId) {
        $('#orderDetailModal').modal('show');
        $('#order-detail-body').html('<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        $.ajax({
            url: "<?php echo e(route('order.detail.json', ':id')); ?>".replace(':id', orderId),
            type: "GET",
            success: function(response) {
                if (response.status) {
                    const order = response.data;
                    let html = `
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="mb-3">Order Information</h6>
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="40%">Order ID:</th>
                                        <td>${order.order_id}</td>
                                    </tr>
                                    <tr>
                                        <th>Customer Name:</th>
                                        <td>${order.name}</td>
                                    </tr>
                                    <tr>
                                        <th>Location:</th>
                                        <td>${order.location || '-'}</td>
                                    </tr>
                                    <tr>
                                        <th>Placed Date:</th>
                                        <td>${order.placed_date_formatted}</td>
                                    </tr>
                                    <tr>
                                        <th>Delivery Date:</th>
                                        <td>${order.deliver_date_formatted || '<span class="text-muted">Not set</span>'}</td>
                                    </tr>
                                    <tr>
                                        <th>Status:</th>
                                        <td>
                                            <span class="badge ${getStatusBadgeClass(order.status)}">${order.status}</span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-3">Payment Information</h6>
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="40%">Amount Paid:</th>
                                        <td>₹${parseFloat(order.amount_paid || 0).toLocaleString('en-IN', {minimumFractionDigits: 2})}</td>
                                    </tr>
                                    <tr>
                                        <th>Amount Remaining:</th>
                                        <td>₹${parseFloat(order.amount_remaining || 0).toLocaleString('en-IN', {minimumFractionDigits: 2})}</td>
                                    </tr>
                                    <tr>
                                        <th>Subtotal:</th>
                                        <td>₹${parseFloat(order.subtotal || 0).toLocaleString('en-IN', {minimumFractionDigits: 2})}</td>
                                    </tr>
                                    <tr>
                                        <th>Delivery Fee:</th>
                                        <td>₹${parseFloat(order.delivery_fee || 0).toLocaleString('en-IN', {minimumFractionDigits: 2})}</td>
                                    </tr>
                                    <tr>
                                        <th>Total Amount:</th>
                                        <td><strong>₹${parseFloat(order.total_amount || 0).toLocaleString('en-IN', {minimumFractionDigits: 2})}</strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    `;

                    if (order.billing) {
                        html += `
                            <div class="mt-3 p-3 bg-light rounded">
                                <h6 class="mb-3">Billing Address</h6>
                                <p><strong>Name:</strong> ${order.billing.full_name || '-'}</p>
                                <p><strong>Phone:</strong> ${order.billing.phone || '-'}</p>
                                <p><strong>Address:</strong> ${order.billing.address || '-'}</p>
                                <p><strong>City:</strong> ${order.billing.city || '-'}</p>
                                <p><strong>State:</strong> ${order.billing.state || '-'}</p>
                            </div>
                        `;
                    }

                    if (order.items && order.items.length > 0) {
                        html += `
                            <div class="mt-4">
                                <h6 class="mb-3">Order Items</h6>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Product ID</th>
                                                <th>Variety</th>
                                                <th>Quality</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                        `;
                        order.items.forEach((item, index) => {
                            html += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${item.product_id}</td>
                                    <td>${item.variety}</td>
                                    <td>${item.quality}</td>
                                    <td>₹${parseFloat(item.price || 0).toLocaleString('en-IN', {minimumFractionDigits: 2})}</td>
                                    <td>${item.quantity || 0}</td>
                                    <td>₹${parseFloat(item.total_price || 0).toLocaleString('en-IN', {minimumFractionDigits: 2})}</td>
                                </tr>
                            `;
                        });
                        html += `
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        `;
                    }

                    $('#order-detail-body').html(html);
                    if (typeof feather !== 'undefined') {
                        feather.replace();
                    }
                }
            },
            error: function() {
                $('#order-detail-body').html('<div class="alert alert-danger">Failed to load order details. Please try again.</div>');
            }
        });
    }

    function getStatusBadgeClass(status) {
        if (status === 'completed') return 'bg-success';
        if (status === 'pending') return 'bg-warning';
        if (status === 'cancelled') return 'bg-danger';
        return 'bg-secondary';
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/appsians/gm-traders-backend/resources/views/dashboard.blade.php ENDPATH**/ ?>