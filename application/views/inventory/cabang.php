<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="success-addCabang" data-cabangadd="<?= $this->session->flashdata('cabangadd'); ?>"></div>
    <div class="success-editCabang" data-cabangedit="<?= $this->session->flashdata('cabangedit'); ?>"></div>
    <div class="success-deleteCabang" data-cabangdelete="<?= $this->session->flashdata('cabangdelete'); ?>"></div>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"><?= $title; ?> List</h6>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <a href="" class="btn btn-primary mb-3 tombolTambahCabang float-left" data-toggle="modal" data-target="#tambahCabang">Tambah Cabang Baru</a>
                </div>
                <div class="col-lg-6">
                    <form method="POST" action="">
                        <div class="input-group">
                            <input type="text" class="form-control" size="50" placeholder="Cari cabang" name="keyword" autocomplete="off" autofocus>
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
                                <th scope="col">Nama Cabang</th>
                                <th scope="col">Alamat Cabang</th>
                                <th scope="col" class="text-right">Telephone</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($cabang as $cabs) : ?>
                                <tr>
                                    <th scope="col"><?= ++$start; ?></th>
                                    <td class="text-center">
                                        <a href="<?= base_url(); ?>inventory/editCabang/<?= $cabs['idCabang']; ?>" class="badge badge-success p-2 tombolEditCabang" data-toggle="modal" data-target="#tambahCabang" data-id="<?= $cabs['idCabang']; ?>">Edit</a>
                                        <a href="<?= base_url(); ?>inventory/deleteCabang/<?= $cabs['idCabang']; ?>" class="badge badge-danger p-2 tombolHapus">Delete</a>
                                    </td>
                                    <td><?= $cabs['namaCabang']; ?></td>
                                    <td><?= $cabs['alamatCabang']; ?></td>
                                    <td class="text-right"><?= $cabs['telpCabang'] ?></td>
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
<div class="modal fade" id="tambahCabang" tabindex="-1" role="dialog" aria-labelledby="tambahCabangLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title judulModalTambahCabang" id="tambahCabangLabel">Tambah Cabang Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="<?= base_url(); ?>inventory/cabang" class="formActive" method="POST">
                <input type="hidden" name="idCabang" id="idCabang">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Nama Cabang" name="namaCabang" id="namaCabang" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Alamat Cabang" name="alamatCabang" id="alamatCabang" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Telephone Cabang" name="telpCabang" id="telpCabang" autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary submitCabang">Add Cabang</button>
                </div>
            </form>
        </div>
    </div>
</div>