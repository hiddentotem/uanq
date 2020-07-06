<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="success-add" data-succadd="<?= $this->session->flashdata('succadd'); ?>"></div>
    <div class="success-edit" data-succedit="<?= $this->session->flashdata('succedit'); ?>"></div>
    <div class="success-delete" data-succdelete="<?= $this->session->flashdata('succdelete'); ?>"></div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"><?= $title ?></h6>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <a href="" class="btn btn-primary mb-3 tombolTambahHarga float-left" data-toggle="modal" data-target="#tambahHarga">Tambah Harga Baru</a>
                </div>
                <div class="col-lg-6">
                    <form method="POST" action="">
                        <div class="input-group">
                            <input type="text" class="form-control" size="50" placeholder="Cari tipe harga" name="keyword" autocomplete="off" autofocus>
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
                                <th scope="col" width="150" class="text-center">Opsi</th>
                                <th scope="col">Last Update</th>
                                <th scope="col">Tipe List</th>
                                <th scope="col" class="text-right">Harga Beli</th>
                                <th scope="col" class="text-right">Harga Jual</th>
                                <th scope="col" class="text-right">Harga Reseller</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($harga as $h) : ?>
                            <tr>
                                <th scope="col"><?= ++$start; ?></th>
                                <td class="text-center">
                                    <a href="<?= base_url(); ?>inventory/editHarga/<?= $h['hargaID']; ?>" class="badge badge-success p-2 tombolEditHarga" data-toggle="modal" data-target="#tambahHarga" data-id="<?= $h['hargaID']; ?>">Edit</a>
                                    <a href="<?= base_url(); ?>inventory/deleteHarga/<?= $h['hargaID']; ?>" class="badge badge-danger p-2 tombolHapus">Delete</a>
                                </td>
                                <td><?= $h['dateModified']; ?></td>
                                <td><?= $h['hargaTipe']; ?></td>
                                <td class="text-right"><?= number_format($h['hargaBeli'], 0, ',', '.'); ?></td>
                                <td class="text-right"><?= number_format($h['hargaJual'], 0, ',', '.'); ?></td>
                                <td class="text-right"><?= number_format($h['hargaReseller'], 0, ',', '.'); ?></td>
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
<div class="modal fade" id="tambahHarga" tabindex="-1" role="dialog" aria-labelledby="tambahHargaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title judulModalTambahHarga" id="tambahHargaLabel">Tambah Harga Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="<?= base_url(); ?>inventory/pricelist" class="formActive" method="POST">
                <input type="hidden" name="hargaID" id="hargaID">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Tipe Harga" name="hargaTipe" id="hargaTipe" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" placeholder="Harga Beli" name="hargaBeli" id="hargaBeli" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" placeholder="Harga Jual" name="hargaJual" id="hargaJual" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" placeholder="Harga Reseller" name="hargaReseller" id="hargaReseller" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" value="<?= date('Y-m-d H:i:s'); ?>" autocomplete="off" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary submitHarga">Add Harga</button>
                </div>
            </form>
        </div>
    </div>
</div>