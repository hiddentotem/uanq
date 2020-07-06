<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="cancel-deals" data-canceldeals="<?= $this->session->flashdata('canceldeals'); ?>"></div>
    <div class="delete-deals" data-deletedeals="<?= $this->session->flashdata('deletedeals'); ?>"></div>
    <div class="edit-deals" data-editdeals="<?= $this->session->flashdata('editdeals'); ?>"></div>
    <div class="fail-edit-deals" data-faileditdeals="<?= $this->session->flashdata('faileditdeals'); ?>"></div>
    <div class="proses-deals" data-prosesdeals="<?= $this->session->flashdata('prosesdeals'); ?>"></div>

    <!-- Area Chart -->
    <div class="row">
        <!-- Line Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Income Outcome This Month</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="myPieChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> Income
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Outcome
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary"><?= $title ?> List</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Sort Deals by</div>
                            <a class="dropdown-item" href="<?= base_url() ?>inventory/sortDeals?start-date=<?= date('Y-m-d'); ?>">Today</a>
                            <a class="dropdown-item" href="<?= base_url() ?>inventory/sortDeals?start-date=<?= date('Y-m-d', strtotime('this week')); ?>&end-date=<?= date('Y-m-d'); ?>&sort=This Week">This Week</a>
                            <a class="dropdown-item" href="<?= base_url() ?>inventory/sortDeals?start-date=<?= date('Y-m-01'); ?>&end-date=<?= date('Y-m-d'); ?>&sort=This Month">This Month</a>
                            <a class="dropdown-item" href="<?= base_url() ?>inventory/sortDeals?start-date=<?= date('Y-01-01'); ?>&end-date=<?= date('Y-m-d'); ?>&sort=This Year">This Year</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#sortbyModal">Custom</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Toambol -->
                    <div class="row">
                        <div class="col-lg-6" id="tombolDeals" data-deals="<?= $count; ?>">
                            <a href="http://localhost:8080/uanq/inventory" title="Tambah transaksi baru" class="btn btn-primary float-left">Transaksi Baru</a>
                            <!-- <a href="" title="Lihat berdasarkan tanggal" class="btn btn-secondary ml-2" id="sortby" data-toggle="modal" data-target="#sortbyModal">Lihat Transaksi</a> -->
                            <div class="dropdown float-left ml-2">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Lihat Transaksi
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">Today</a>
                                    <a class="dropdown-item" href="#">Last Week</a>
                                    <a class="dropdown-item" href="#">Last 30 Days</a>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#sortbyModal">Custom</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="row">
                        <div class="col-lg">
                            <div class="d-flex justify-content-between mt-3 mb-2">
                                <div class="">
                                    <h6 class="h6">Tanggal&nbsp;&nbsp;:&nbsp; <?= date('l, d M Y'); ?></h6>
                                </div>
                                <div class="">
                                    <h6 class="h6">Jumlah Deal&nbsp;&nbsp;:&nbsp; <?= $count; ?> </h6>
                                </div>
                                <div class="">
                                    <h6 class="h6">Total Deal&nbsp;&nbsp;:&nbsp; Rp. <?= number_format($total, 0, '.', ','); ?></h6>
                                </div>
                                <div class="">
                                    <h6 class="h6">Total Profit&nbsp;&nbsp;:&nbsp; Rp. <?= number_format($profit, 0, '.', ','); ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="row">
                        <div class="col-lg">
                            <table class="table table-hover" style="display: block; overflow-x: auto; white-space: nowrap;">
                                <thead>
                                    <tr>
                                        <th scope="col" width="50">#</th>
                                        <th scope="col" width="200" class="text-center">Option</th>
                                        <th scope="col">Nama Barang</th>
                                        <th scope="col">Nama Customer</th>
                                        <th scope="col">Tanggal Order</th>
                                        <th scope="col">Status</th>
                                        <th scope="col" class="text-right">Qty</th>
                                        <th scope="col" class="text-right">Harga Satuan</th>
                                        <th scope="col" class="text-right">Total Harga</th>
                                        <th scope="col" class="text-right">Profit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($deals as $order) : ?>
                                    <tr>
                                        <th scope="col"><?= $i++; ?></th>
                                        <td class="text-center">
                                            <a href="<?= base_url(); ?>inventory/orderDetail/<?= $order['idOrder']; ?>" class="badge badge-primary p-2 tombolEditOrder">Detail</a>
                                            <a href="<?= base_url(); ?>inventory/editOrder/<?= $order['idOrder']; ?>" class="badge badge-success p-2 tombolEditOrder" data-toggle="modal" data-target="#editOrderModal" data-id="<?= $order['idOrder']; ?>">Edit</a>
                                            <a href="<?= base_url(); ?>inventory/deleteOrder/<?= $order['idOrder']; ?>" class="badge badge-danger p-2 tombolHapus">Delete</a>
                                        </td>
                                        <td><?= $order['namaBarang']; ?></td>
                                        <td><?= $order['customerName']; ?></td>
                                        <td><?= Date('d-m-Y', strtotime($order['dateCreated'])); ?></td>
                                        <?php if($order['status'] == 1): ?>
                                        <th class="text-right text-danger">PROCESS</th>
                                        <?php else : ?>
                                        <th class="text-right text-success">ARRIVED</th>
                                        <?php endif; ?>
                                        <td class="text-right"><?= $order['qtyOrder']; ?></td>
                                        <td class="text-right"><?= number_format($order['hargaJual'], 0, ',', '.'); ?></td>
                                        <td class="text-right"><?= number_format($order['totalHarga'], 0, ',', '.'); ?></td>
                                        <td class="text-right"><?= number_format($order['profitOrder'], 0, ',', '.'); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal Proses Orders -->
<div class="modal fade" id="sortbyModal" tabindex="-1" role="dialog" aria-labelledby="sortbyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title judulModalEarning" id="sortbyModalLabel">Sort Deals by Date</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="<?= base_url(); ?>inventory/sortDeals" class="formActive" method="GET">
                <input type="hidden" name="sort" value="Sorted">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="start-date">Start Date</label>
                                <input type="text" class="form-control" name="start-date" id="start-date">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group end-date-picker">
                                <!-- Append by JS -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary submitOrder">Sort</button>
                </div>
            </form>
        </div>
    </div>
</div>