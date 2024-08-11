<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="clearfix">
        <div class="float-left">
            <h1 class="h3 m-0 text-gray-800">Pelanggan</h1>
        </div>
        <div class="float-right">
            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahPelangganModal"><i class="fas fa-file-alt"></i> Pelanggan Baru</a>
        </div>
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
            <strong>Data Pelanggan</strong>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Nomor KWH</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Daya</th>
                            <th>Tarif per kWh</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pelanggan as $item) : ?>
                            <tr>
                                <td><?php echo $item['username']; ?></td>
                                <td><?php echo $item['nomor_kwh']; ?></td>
                                <td><?php echo $item['nama_pelanggan']; ?></td>
                                <td><?php echo $item['alamat']; ?></td>
                                <td><?php echo $item['daya']; ?></td>
                                <td><?php echo $item['tarifperkwh']; ?></td>
                                <td>
                                    <a href="<?php echo base_url('pelanggan/edit/' . $item['id_pelanggan']); ?>" class="btn btn-info mb-3"><i class="fas fa-edit fa-sm text-white-50"></i></a> |
                                    <a href="javascript:void(0);" class="btn btn-danger mb-3 btn-delete" data-id="<?php echo $item['id_pelanggan']; ?>"><i class="fas fa-trash fa-sm text-white-50"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<!-- Modal Tambah Pelanggan baru -->
<div class="modal fade" id="tambahPelangganModal" tabindex="-1" role="dialog" aria-labelledby="tambahPelangganModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahPelangganModalLabel">Tambah Pelanggan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('pelanggan/tambah'); ?>" method="post">
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
                        <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
                        <input type="text" class="form-control form-control-user" id="nama_pelanggan" name="nama_pelanggan" placeholder="Masukkan Nama Pelanggan">
                    </div>
                    <div class="form-group">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control form-control-user" id="alamat" name="alamat" placeholder="Masukkan Alamat">
                    </div>
                    <div class="form-group">
                        <label for="id_tarif" class="form-label">Tarif</label>
                        <select class="form-control" id="id_tarif" name="id_tarif">
                            <?php foreach ($tarif as $t) : ?>
                                <option value="<?= $t['id_tarif']; ?>"><?= $t['daya']; ?></option>
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
<!-- End of Modal Tambah Pelanggan -->

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
                Apakah Anda yakin ingin menghapus pelanggan ini?
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
            $('#confirmDelete').attr('href', '<?= base_url('pelanggan/delete/') ?>' + id);
            $('#deleteModal').modal('show');
        });
    });
</script>