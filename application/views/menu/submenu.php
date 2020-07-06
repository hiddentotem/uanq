<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <!-- Sub menu view -->
    <div class="row">
        <div class="col-lg">
            <div class="card shadow mb-4">
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

                <div class="card-body">
                    <!-- Errors message -->
                    <?php if (validation_errors()) : ?>
                        <div class="alert alert-danger" role="alert"><?= validation_errors(); ?></div>
                    <?php endif; ?>
                    <!-- End Errors message -->

                    <?= $this->session->flashdata('message'); ?>

                    <table class="table table-hover">
                        <!-- Trigger modal -->
                        <a href="" class="btn btn-primary mb-3 tombolTambahSubmenu" data-toggle="modal" data-target="#newSubMenuModal">Add New Submenu</a>
                        <!-- End Trigger modal -->

                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Judul Submenu</th>
                                <th scope="col">Menu</th>
                                <th scope="col">URL</th>
                                <th scope="col">Icon</th>
                                <th scope="col">Active</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($submenu as $sm) : ?>
                                <tr>
                                    <th scope="row"><?= $i++; ?></th>
                                    <td><?= $sm['judulSubMenu']; ?></td>
                                    <td><?= $sm['namaMenu']; ?></td>
                                    <td><?= $sm['urlSubMenu']; ?></td>
                                    <td><?= $sm['iconSubMenu']; ?></td>
                                    <td><?= $sm['isActiveMenu']; ?></td>
                                    <td>
                                        <a href="<?= base_url(); ?>menu/submenuedit/<?= $sm['idSubMenu']; ?>" class="badge badge-success tombolEditSubmenu" data-toggle="modal" data-target="#newSubMenuModal" data-id="<?= $sm['idSubMenu']; ?>">edit</a>
                                        <a href="<?= base_url(); ?>menu/submenudelete/<?= $sm['idSubMenu']; ?>" class="badge badge-danger" onclick="return confirm('Are you sure want to delete?')">delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- End Sub menu view -->

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<!-- Modal -->
<div class="modal fade" id="newSubMenuModal" tabindex="-1" role="dialog" aria-labelledby="newSubMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title judulModalSubmenu" id="newSubMenuModalLabel">Add New Submenu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="<?= base_url(); ?>menu/submenu" class="formActive" method="POST">
                <input type="hidden" name="idSubmenu" id="idSubmenu">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Submenu Title" name="judulSubmenu" id="judulSubmenu">
                    </div>
                    <div class="form-group">
                        <select name="menu_id" id="menu_id" class="form-control">
                            <option value="" disabled selected>Select Menu</option>
                            <?php foreach ($menu as $m) : ?>
                                <option value="<?= $m['idMenu']; ?>"><?= $m['namaMenu']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="URL Submenu" name="urlSubmenu" id="urlSubmenu">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Icon Submenu" name="iconSubmenu" id="iconSubmenu">
                    </div>
                    <div class="form-group">
                        <select name="isActive" id="isActive" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Deactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary submitSubmenu">Add Menu</button>
                </div>
            </form>
        </div>
    </div>
</div>