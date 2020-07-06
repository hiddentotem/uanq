<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="success-earning" data-searning="<?= $this->session->flashdata('searning'); ?>"></div>
    <div class="delete-earning" data-delearning="<?= $this->session->flashdata('delearning'); ?>"></div>
    <div class="edit-earning" data-edearning="<?= $this->session->flashdata('edearning'); ?>"></div>
    <div class="edit-earningx" data-edearningx="<?= $this->session->flashdata('edearningx'); ?>"></div>

    <div class="row">
        <div class="col-lg">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary"><?= $title; ?> List</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Sort earnings by</div>
                            <a class="dropdown-item" href="#">Today</a>
                            <a class="dropdown-item" href="#">This Week</a>
                            <a class="dropdown-item" href="#">This Month</a>
                            <a class="dropdown-item" href="#">This Year</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#exampleModal">Custom</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Trigger modal -->
                    <a href="" class="btn btn-primary mb-3 tombolTambahEarning" data-toggle="modal" data-target="#newEarningModal">Add New Earning</a>
                    <!-- <a href="" class="btn btn-secondary mb-3 tombolSeeEarning" data-toggle="modal" data-target="#exampleModal">See Earning</a> -->

                    <!-- Info -->
                    <div class="d-flex justify-content-between mt-3 mb-2">
                        <div class="">
                            <h6 class="h6">Tanggal&nbsp;&nbsp;:&nbsp; <?= $date; ?></h6>
                        </div>
                        <div class="">
                            <h6 class="h6">Balance&nbsp;&nbsp;:&nbsp; Rp. <?= number_format($balance, 0, ',', '.'); ?></h6>
                        </div>
                        <div class="">
                            <h6 class="h6">Income Today&nbsp;&nbsp;:&nbsp; Rp. <?= number_format($sumIncome, 0, ',', '.'); ?></h6>
                        </div>
                        <div class="">
                            <h6 class="h6">Outcome Today&nbsp;&nbsp;:&nbsp; Rp. <?= number_format($sumOutcome, 0, ',', '.'); ?></h6>
                        </div>
                    </div>

                    <!-- Table Earning -->
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col" width="50">#</th>
                                <th scope="col" width="250" class="text-center">Option</th>
                                <th scope="col">Transaction</th>
                                <th scope="col">Date</th>
                                <th scope="col" class="text-right">Income</th>
                                <th scope="col" class="text-right">Outcome</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($earnings as $earning) : ?>
                                <tr>
                                    <th scope="col"><?= $i++; ?></th>
                                    <td class="text-center">
                                        <a href="<?= base_url(); ?>user/earningDetail/<?= $earning['idEarning']; ?>" class="badge badge-primary p-2 tombolEditEarning">Detail</a>
                                        <a href="<?= base_url(); ?>user/earningEdit/<?= $earning['idEarning']; ?>" class="badge badge-success p-2 tombolEditEarning" data-toggle="modal" data-target="#newEarningModal" data-id="<?= $earning['idEarning']; ?>">Edit</a>
                                        <a href="<?= base_url(); ?>user/earningDelete/<?= $earning['idEarning']; ?>" class="badge badge-danger p-2 tombolHapus">Delete</a>
                                    </td>
                                    <td><?= $earning['transaksi']; ?></td>
                                    <td><?= $earning['dateCreated']; ?></td>
                                    <th class="text-right text-success"><?= number_format($earning['income'], 0, ',', '.'); ?></th>
                                    <th class="text-right text-danger"><?= number_format($earning['outcome'], 0, ',', '.'); ?></th>
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

<!-- Modal -->
<div class="modal fade" id="newEarningModal" tabindex="-1" role="dialog" aria-labelledby="newEarningModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title judulModalEarning" id="newEarningModalLabel">Add New Earning</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="<?= base_url(); ?>user/earning" class="formActive" method="POST">
                <input type="hidden" name="idEarning" id="idEarning">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Transaction" name="judulTransaksi" id="judulTransaksi">
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" placeholder="Income" name="incomeTransaksi" id="incomeTransaksi">
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" placeholder="Outcome" name="outcomeTransaksi" id="outcomeTransaksi">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Date" name="dateCreated" id="dateCreated" readonly value="<?= date('Y-m-d'); ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary submitEarning">Add Earning</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal date -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Lihat Transaksi Berdasarkan Tanggal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="<?= base_url(); ?>user/earningSee">
                <div class="modal-body">
                    <div class="row mx-auto">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label for="datepicker">Dari tanggal</label>
                                <input type="text" width="276" class="form-control" id="datepicker" name="startDate" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="form-group end-date">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Lihat Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>