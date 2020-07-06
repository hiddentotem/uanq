<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="cancel-order" data-cancelorder="<?= $this->session->flashdata('cancelorder'); ?>"></div>
    <div class="delete-order" data-deleteorder="<?= $this->session->flashdata('deleteorder'); ?>"></div>
    <div class="edit-order" data-editorder="<?= $this->session->flashdata('editorder'); ?>"></div>
    <div class="fail-edit-order" data-faileditorder="<?= $this->session->flashdata('faileditorder'); ?>"></div>
    <div class="proses-order" data-prosesorder="<?= $this->session->flashdata('prosesorder'); ?>"></div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"><?= $title ?> List</h6>
        </div>

        <div class="card-body">
            <!-- Toambol -->
            <div class="row">
                <div class="col-lg-6" id="tombolOrder" data-order="<?= $count; ?>">
                    <!-- Tombolnya bakal digenerate sama js -->
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
                            <h6 class="h6">Jumlah Order&nbsp;&nbsp;:&nbsp; <?= $count; ?> </h6>
                        </div>
                        <div class="">
                            <h6 class="h6">Total Order&nbsp;&nbsp;:&nbsp; Rp. <?= number_format($total, 0, '.', ','); ?></h6>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="row">
                <div class="col-lg">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col" width="50">#</th>
                                <th scope="col" width="200" class="text-center">Option</th>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">Nama Customer</th>
                                <th scope="col" class="text-right">Qty</th>
                                <th scope="col" class="text-right">Harga Satuan</th>
                                <th scope="col" class="text-right">Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($orders as $order) : ?>
                            <tr>
                                <th scope="col"><?= $i++; ?></th>
                                <td class="text-center">
                                    <a href="<?= base_url(); ?>inventory/orderDetail/<?= $order['idOrder']; ?>" class="badge badge-primary p-2 tombolEditOrder">Detail</a>
                                    <a href="<?= base_url(); ?>inventory/editOrder/<?= $order['idOrder']; ?>" class="badge badge-success p-2 tombolEditOrder" data-toggle="modal" data-target="#editOrderModal" data-id="<?= $order['idOrder']; ?>">Edit</a>
                                    <a href="<?= base_url(); ?>inventory/deleteOrder/<?= $order['idOrder']; ?>" class="badge badge-danger p-2 tombolHapus">Delete</a>
                                </td>
                                <td><?= $order['namaBarang']; ?></td>
                                <td><?= $order['customerName']; ?></td>
                                <td class="text-right"><?= $order['qtyOrder']; ?></td>
                                <th class="text-right text-success"><?= number_format($order['hargaJual'], 0, ',', '.'); ?></th>
                                <th class="text-right text-danger"><?= number_format($order['totalHarga'], 0, ',', '.'); ?></th>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal Proses Orders -->
<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title judulModalEarning" id="formModalLabel">Proses Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="<?= base_url(); ?>inventory/prosesOrder" class="formActive" method="POST">
                <input type="hidden" name="idOrder" id="idOrder">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="uangDiterima">Uang Diterima</label>
                                <input type="text" class="form-control" name="uangDiterima" id="uangDiterima">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="kembalian">Kembalian</label>
                                <input type="text" class="form-control" name="kembalian" id="kembalian" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="total-belanja">Total Belanja</label>
                                <input type="text" class="form-control" id="total-belanja" name="total-belanja" value="<?= $total; ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary submitOrder">Proses Order</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Orders -->
<div class="modal fade" id="editOrderModal" tabindex="-1" role="dialog" aria-labelledby="editOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title judulModalOrder" id="editOrderModalLabel">Edit Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="<?= base_url(); ?>inventory/editOrder" class="formActive" method="POST">
                <input type="hidden" name="idOrders" id="idOrders">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="customerName">Nama Customer</label>
                                <input type="text" class="form-control" id="customerName" name="customerName">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="namaBarang">Nama Barang</label>
                                <input type="text" class="form-control" id="namaBarang" name="namaBarang" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="harga">Harga</label>
                                <select class="form-control" name="harga" id="harga">
                                    <!-- Append by ajax -->
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="number" class="form-control" name="quantity" id="quantity" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="totalHarga">Total Harga</label>
                                <input type="text" class="form-control" id="totalHarga" name="totalHarga" readonly>
                                <input type="hidden" class="form-control" id="hargaModal" name="hargaModal" autocomplete="off" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary editOrder">Edit Order</button>
                </div>
            </form>
        </div>
    </div>
</div>