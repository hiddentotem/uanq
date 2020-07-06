<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="success-add" data-succadd="<?= $this->session->flashdata('succadd'); ?>"></div>
    <div class="success-edit" data-succedit="<?= $this->session->flashdata('succedit'); ?>"></div>
    <div class="success-delete" data-succdelete="<?= $this->session->flashdata('succdelete'); ?>"></div>
    <div class="fail-add" data-failadd="<?= $this->session->flashdata('failadd'); ?>"></div>

    <div class="success-addorder" data-addorder="<?= $this->session->flashdata('addorder'); ?>"></div>
    <div class="fail-addorder" data-failorder="<?= $this->session->flashdata('failorder'); ?>"></div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"><?= $title ?> List</h6>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <a href="" class="btn btn-primary mb-3 tombolTambahBarang float-left" data-toggle="modal" data-target="#tambahBarang">Tambah Barang Baru</a>
                    <div class="dropdown ml-2 float-left">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Pilih Cabang
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="<?= base_url(); ?>inventory">Semua Cabang</a>
                            <?php foreach ($cabang as $cab) : ?>
                            <a class="dropdown-item" href="<?= base_url(); ?>inventory?id=<?= $cab['idCabang']; ?>"><?= $cab['namaCabang']; ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <form method="POST" action="">
                        <div class="input-group">
                            <input type="text" class="form-control" size="50" placeholder="Cari barang" name="keyword" autocomplete="off" autofocus>
                            <div class="input-group-append">
                                <input class="btn btn-primary" type="submit" name="submit">
                            </div>
                        </div>
                    </form>
                    <h6 class="form-text text-grey ml-3">Result : <?= $total_rows; ?></h6>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-lg-12">
                    <!-- Table Produk -->
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col" width="50">#</th>
                                <th scope="col" width="200" class="text-center">Opsi</th>
                                <th scope="col">Cabang</th>
                                <th scope="col">Nama Produk</th>
                                <th scope="col" class="text-right">Terjual</th>
                                <th scope="col" class="text-right">Process</th>
                                <th scope="col" class="text-right">Harga Beli</th>
                                <th scope="col" class="text-right">Harga Jual</th>
                                <th scope="col" class="text-right">Harga Resell</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($produk as $p) : ?>
                            <tr>
                                <th scope="col"><?= ++$start; ?></th>
                                <td class="text-center">
                                    <a href="<?= base_url(); ?>inventory/orderProduk/<?= $p['produkID']; ?>" class="badge badge-primary p-2 tombolOrderBarang" data-toggle="modal" data-target="#formModal" data-idorder="<?= $p['produkID']; ?>">Order</a>
                                    <a href="<?= base_url(); ?>inventory/editBarang/<?= $p['produkID']; ?>" class="badge badge-success p-2 tombolEditBarang" data-toggle="modal" data-target="#tambahBarang" data-id="<?= $p['produkID']; ?>">Edit</a>
                                    <a href="<?= base_url(); ?>inventory/deleteBarang/<?= $p['produkID']; ?>" class="badge badge-danger p-2 tombolHapus">Delete</a>
                                </td>
                                <td><?= $p['namaCabang']; ?></td>
                                <td><?= $p['produkNama']; ?></td>
                                <td class="text-right"><?= number_format($p['produkTerjual'], 0, ',', '.'); ?></td>
                                <td class="text-right"><?= number_format($p['produkProcess'], 0, ',', '.'); ?></td>
                                <td class="text-right"><?= number_format($p['hargaBeli'], 0, ',', '.'); ?></td>
                                <td class="text-right"><?= number_format($p['hargaJual'], 0, ',', '.'); ?></td>
                                <td class="text-right"><?= number_format($p['hargaReseller'], 0, ',', '.'); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <span><?= $this->pagination->create_links(); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal Tambah edit -->
<div class="modal fade" id="tambahBarang" tabindex="-1" role="dialog" aria-labelledby="tambahBarangLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title judulModalTambahBarang" id="tambahBarangLabel">Tambah Barang Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="<?= base_url(); ?>inventory/products" class="formActive" method="POST">
                <input type="hidden" name="produkID" id="produkID">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Nama Produk" name="produkNama" id="produkNama" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="cabang" id="cabang">
                            <option value="0" disabled selected>Pilih Cabang</option>
                            <?php foreach ($cabang as $cab) : ?>
                            <option value="<?= $cab['idCabang']; ?>"><?= $cab['namaCabang']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="list-harga" id="list-harga">
                            <option value="0" disabled selected>Pilih List Harga</option>
                            <?php foreach ($listharga as $list) : ?>
                            <option value="<?= $list['hargaID']; ?>"><?= $list['hargaTipe']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" placeholder="Harga Beli" name="hargaBeli" id="hargaBeli" autocomplete="off" readonly>
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" placeholder="Harga Jual" name="hargaJual" id="hargaJual" autocomplete="off" readonly>
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" placeholder="Harga Reseller" name="hargaReseller" id="hargaReseller" autocomplete="off" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary submitBarang">Add Produk</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Order -->
<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judulModal">Tambah Data Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url(); ?>inventory/orderbarang" method="POST">
                <input type="hidden" name="produkIDs" id="produkIDs">
                <input type="hidden" name="cabangID" id="cabangID">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="customerName">Nama Customer</label>
                                <input type="text" class="form-control" name="customerName" id="customerName" autocomplete="off" placeholder="Nama Customer">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="produk">Produk</label>
                                <input type="text" class="form-control" id="produk" name="produk" autocomplete="off" readonly>
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
                                <input type="number" class="form-control" id="quantity" name="quantity" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="totalHarga">Total Harga</label>
                                <input type="number" class="form-control" id="totalHarga" name="totalHarga" autocomplete="off" readonly>
                                <input type="hidden" class="form-control" id="hargaModal" name="hargaModal" autocomplete="off" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="text" class="form-control" id="date" name="date" value="<?= date('Y-m-d H:i:s'); ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="submitData">Tambah Order</button>
                </div>
            </form>
        </div>
    </div>
</div>