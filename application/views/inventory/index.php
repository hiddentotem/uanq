<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="success-add" data-produkadd="<?= $this->session->flashdata('produkadd'); ?>"></div>
    <div class="success-update" data-produkupd="<?= $this->session->flashdata('produkupd'); ?>"></div>
    <div class="success-delete" data-produkdel="<?= $this->session->flashdata('produkdel'); ?>"></div>
    <div class="success-addorder" data-addorder="<?= $this->session->flashdata('addorder'); ?>"></div>
    <div class="fail-addorder" data-failorder="<?= $this->session->flashdata('failorder'); ?>"></div>
    <div class="fail-form" data-failform="<?= $this->session->flashdata('failform'); ?>"></div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"><?= $title ?> List</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Pilih Cabang</div>
                    <a class="dropdown-item" href="<?= base_url(); ?>inventory">Semua Cabang</a>
                    <?php foreach ($cabang as $cab) : ?>
                        <a class="dropdown-item" href="<?= base_url(); ?>inventory?id=<?= $cab['idCabang']; ?>"><?= $cab['namaCabang']; ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <a href="" class="btn btn-primary mb-3 tombolTambahProduk float-left" data-toggle="modal" data-target="#tambahProduk">Tambah Barang Baru</a>
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
                                <th scope="col" class="text-right">Stok</th>
                                <th scope="col" class="text-right">Terjual</th>
                                <th scope="col" class="text-right">Harga Beli</th>
                                <th scope="col" class="text-right">Harga Jual</th>
                                <th scope="col" class="text-right">Profit</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($produk as $p) : ?>
                                <tr>
                                    <th scope="col"><?= ++$start; ?></th>
                                    <td class="text-center">
                                        <a href="<?= base_url(); ?>inventory/orderProduk/<?= $p['idProduk']; ?>" class="badge badge-primary p-2 tombolOrder" data-toggle="modal" data-target="#formModal" data-idorder="<?= $p['idProduk']; ?>">Order</a>
                                        <a href="<?= base_url(); ?>inventory/editProduk/<?= $p['idProduk']; ?>" class="badge badge-success p-2 tombolEditProduk" data-toggle="modal" data-target="#tambahProduk" data-id="<?= $p['idProduk']; ?>">Edit</a>
                                        <a href="<?= base_url(); ?>inventory/deleteProduk/<?= $p['idProduk']; ?>" class="badge badge-danger p-2 tombolHapus">Delete</a>
                                    </td>
                                    <td><?= $p['namaCabang']; ?></td>
                                    <td><?= $p['namaProduk']; ?></td>
                                    <td class="text-right"><?= number_format($p['stokProduk'], 0, ',', '.'); ?></td>
                                    <td class="text-right"><?= number_format($p['terjualProduk'], 0, ',', '.'); ?></td>
                                    <td class="text-right"><?= number_format($p['hargaBeli'], 0, ',', '.'); ?></td>
                                    <td class="text-right"><?= number_format($p['hargaJual'], 0, ',', '.'); ?></td>
                                    <th class="text-right text-success"><?= number_format($p['profitProduk'], 0, ',', '.'); ?></th>
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
<div class="modal fade" id="tambahProduk" tabindex="-1" role="dialog" aria-labelledby="tambahProdukLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title judulModalTambahProduk" id="tambahProdukLabel">Tambah Produk Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="<?= base_url(); ?>inventory" class="formActive" method="POST">
                <input type="hidden" name="idProduk" id="idProduk">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Nama Produk" name="namaProduk" id="namaProduk" autocomplete="off">
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
                        <input type="number" class="form-control" placeholder="Stok Produk" name="stokProduk" id="stokProduk" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" placeholder="Harga Beli" name="hargaBeli" id="hargaBeli" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" placeholder="Harga Jual" name="hargaJual" id="hargaJual" autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary submitProduk">Add Produk</button>
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
            <form action="<?= base_url(); ?>inventory/addOrders" method="POST">
                <input type="hidden" name="idProduks" id="idProduks">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="produk">Produk</label>
                                <input type="text" class="form-control" id="produk" name="produk" autocomplete="off" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="stoky">Stok</label>
                                <input type="number" class="form-control" id="stoky" name="stoky" autocomplete="off" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="qty">Quantity</label>
                                <input type="number" class="form-control" id="qty" name="qty" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="text" class="form-control" id="date" name="date" value="<?= date('Y-m-d'); ?>" readonly>
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