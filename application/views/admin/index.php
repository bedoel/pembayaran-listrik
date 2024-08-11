<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="clearfix">
        <div class="float-left">
            <h1 class="h3 m-0 text-gray-800">Admin</h1>
        </div>
        <?php if ($this->session->userdata('level') === 'Administrator') : ?>
            <div class="float-right">
                <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahAdminModal"><i class="fas fa-file-alt"></i> Admin Baru</a>
            </div>
        <?php endif; ?>
    </div>
    <hr>
    <?php echo validation_errors(); ?>

    <!-- Notifikasi -->
    <?php if ($this->session->flashdata('success')) : ?>
        <div class="alert alert-success">
            <?= $this->session->flashdata('success'); ?>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')) : ?>
        <div class="alert alert-danger">
            <?= $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>
    <!-- End of Notifikasi -->

    <!-- DataTales Example -->
    <div class="card shadow">
        <div class="card-header">
            <strong>Data Admin</strong>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Nama Admin</th>
                            <th>Level</th>
                            <?php if ($this->session->userdata('level') === 'Administrator') : ?>
                                <th>Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($admin as $item) : ?>
                            <tr>
                                <td><?php echo $item['username']; ?></td>
                                <td><?php echo $item['nama_admin']; ?></td>
                                <td><?php echo $item['nama_level']; ?></td>
                                <?php if ($this->session->userdata('level') === 'Administrator') : ?>
                                    <td>
                                        <a href="<?php echo base_url('admin/edit/' . $item['id_user']); ?>" class="btn btn-info mb-3"><i class="fas fa-edit fa-sm text-white-50"></i></a> |
                                        <a href="javascript:void(0);" class="btn btn-danger mb-3 btn-delete" data-id="<?php echo $item['id_user']; ?>"><i class="fas fa-trash fa-sm text-white-50"></i></a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<!-- Modal Tambah Admin baru -->
<div class="modal fade" id="tambahAdminModal" tabindex="-1" role="dialog" aria-labelledby="tambahAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahAdminModalLabel">Tambah Admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/tambah'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Masukkan Username">
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Masukkan Password">
                    </div>
                    <div class="form-group">
                        <label for="nama_admin" class="form-label">Nama Admin</label>
                        <input type="text" class="form-control form-control-user" id="nama_admin" name="nama_admin" placeholder="Masukkan Nama Admin">
                    </div>
                    <div class="form-group">
                        <label for="id_level" class="form-label">level</label>
                        <select class="form-control" id="id_level" name="id_level">
                            <?php foreach ($level as $l) : ?>
                                <option value="<?= $l['id_level']; ?>"><?= $l['nama_level']; ?></option>
                            <?php endforeach; ?>
                        </select>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i> Close</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Modal Tambah Admin -->

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus admin ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a href="#" id="confirmDelete" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>

<!-- Script untuk mengisi href di modal -->
<script>
    $(document).ready(function() {
        $('.btn-delete').on('click', function() {
            var id = $(this).data('id');
            $('#confirmDelete').attr('href', '<?= base_url('admin/delete/') ?>' + id);
            $('#deleteModal').modal('show');
        });
    });
</script>