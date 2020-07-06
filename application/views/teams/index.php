<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="fail-add" data-failadd="<?= $this->session->flashdata('failadd'); ?>"></div>
    <div class="success-add-team" data-succaddteam="<?= $this->session->flashdata('succaddteam'); ?>"></div>

    <div class="card shadow mb-4 cek-exist" data-teamexist="<?= $user['idTeam']; ?>">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"><?= $title ?> List</h6>
            <div class="dropdown no-arrow opsi-team">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Teams</div>
                    <a class="dropdown-item">Setting Team</a>
                    <a class="dropdown-item">Shutdown Team</a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 tombol-team">
                    <!-- Append by js -->
                </div>
                <div class="col-lg-6 search-field">
                    <form method="POST" action="">
                        <div class="input-group">
                            <input type="text" class="form-control" size="50" placeholder="Cari barang" name="keyword" autocomplete="off" autofocus>
                            <div class="input-group-append">
                                <input class="btn btn-primary" type="submit" name="submit">
                            </div>
                        </div>
                    </form>
                    <h6 class="text-grey mt-2 ml-2">Result :</h6>
                </div>
            </div>
            <div class="row table-team">
                <div class="col-lg">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Crew</th>
                                <th scope="col">Jabatan</th>
                                <th scope="col">Tanggal Join</th>
                                <th scope="col">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach($crew as $c) : ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $c['email'] ?></td>
                                    <td><?= $c['jabatan'] ?></td>
                                    <td><?= $c['dateCreated'] ?></td>
                                    <td>
                                        <a href="#" class="btn-sm btn-primary" role="button">Detail</a>
                                        <a href="#" class="btn-sm btn-success" role="button">Update</a>
                                        <a href="#" class="btn-sm btn-danger" role="button">Kick</a>
                                    </td>
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

<!-- Modal Create Teams -->
<div class="modal fade" id="createTeam" tabindex="-1" role="dialog" aria-labelledby="createTeamLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title judulModalcreateTeam" id="createTeamLabel">Create new Team</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="<?= base_url(); ?>user/addTeam" class="form-team" method="POST">
                <input type="hidden" name="idTeam" id="idTeam">
                <div class="modal-body">
                    <div class="form-group">
                        <select class="form-control" name="bisnis" id="bisnis">
                            <option value="0" disabled selected>Pilih Bisnis</option>
                            <?php foreach($bisnis as $b) :?>
                                <option value="<?= $b['idBisnis'] ?>"><?= $b['namaBisnis']; ?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Nama Team" name="nama-team" id="nama-team" autocomplete="off">
                    </div>
                    <div class="form-group stats">
                        <select class="form-control" name="is-active" id="is-active">
                            <option value="1">Active</option>
                            <option value="0">Non-active</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary submitTeam">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Add new Crew -->
<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judulModal">Recruit new Crew</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url(); ?>user/team" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <select class="form-control" name="jabatan-crew" id="jabatan-crew">
                                    <option value="0" selected disabled>Jabatan Crew</option>
                                    <option value="Kasir">Kasir</option>
                                    <option value="Manager">Manager</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-10">
                            <div class="form-group">
                                <input type="text" class="form-control" id="email-crew" name="email-crew" autocomplete="off" placeholder="Email crew">
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="form-group">
                                <button type="button" class="btn btn-secondary px-3 tombol-cek"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                Please cek dulu email yang ingin di recruit, apakah email tersebut memungkinkan untuk di invite.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer crew-footer">
                    <!-- Append by js -->
                </div>
            </form>
        </div>
    </div>
</div>