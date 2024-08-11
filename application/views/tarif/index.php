<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="clearfix">
        <div class="float-left">
            <h1 class="h3 m-0 text-gray-800">Tarif</h1>
        </div>
        <div class="float-right">
            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahTarifModal"><i class="fas fa-file-alt"></i> Tambah Tarif</a>
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
            <strong>Tarif</strong>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Daya</th>
                            <th>Tarif per kWh</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tarif as $item) : ?>
                            <tr>
                                <td><?php echo $item['daya']; ?></td>
                                <td><?php echo $item['tarifperkwh']; ?></td>
                                <td>
                                    <a href="<?php echo base_url('tarif/edit/' . $item['id_tarif']); ?>" class="btn btn-info mb-3"><i class="fas fa-edit fa-sm text-white-50"></i></a> |
                                    <a href="javascript:void(0);" class="btn btn-danger mb-3 btn-delete" data-id="<?php echo $item['id_tarif']; ?>"><i class="fas fa-trash fa-sm text-white-50"></i></a>
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

<!-- Modal Tambah Tarif baru -->
<div class="modal fade" id="tambahTarifModal" tabindex="-1" role="dialog" aria-labelledby="tambahTarifModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahTarifModalLabel">Tambah Tarif</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('tarif/store'); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="daya" class="form-label">Daya</label>
                        <input type="text" class="form-control form-control-user" id="daya" name="daya" placeholder="Masukkan Daya">
                    </div>
                    <div class="form-group">
                        <label for="tarifperkwh" class="form-label">Tarif per kWh</label>
                        <input type="text" class="form-control form-control-user" id="tarifperkwh" name="tarifperkwh" placeholder="Masukkan Tarif per kWh">
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
<!-- End of Modal Tambah Tarif -->

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
                Apakah Anda yakin ingin menghapus tarif ini?
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
            $('#confirmDelete').attr('href', '<?= base_url('tarif/delete/') ?>' + id);
            $('#deleteModal').modal('show');
        });
    });
</script>