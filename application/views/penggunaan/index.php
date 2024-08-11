<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="clearfix">
        <div class="float-left">
            <h1 class="h3 m-0 text-gray-800">Penggunaan</h1>
        </div>
        <?php if ($this->session->userdata('role') === 'admin') : ?>
            <div class="float-right">
                <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahPenggunaanModal"><i class="fas fa-file-alt"></i> Tambah Data</a>
            </div>
        <?php endif; ?>
    </div>
    <hr>


    <!-- DataTales Example -->
    <div class="card shadow">
        <div class="card-header">
            <strong>Data Penggunaan</strong>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama Pelanggan</th>
                            <th>Nomor KWH</th>
                            <th>Bulan</th>
                            <th>Tahun</th>
                            <th>Meter Awal</th>
                            <th>Meter Akhir</th>
                            <?php if ($this->session->userdata('role') === 'admin') : ?>
                                <th>Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($penggunaan as $item) : ?>
                            <tr>
                                <td><?php echo $item['nama_pelanggan']; ?></td>
                                <td><?php echo $item['nomor_kwh']; ?></td>
                                <td><?php echo $item['bulan']; ?></td>
                                <td><?php echo $item['tahun']; ?></td>
                                <td><?php echo $item['meter_awal']; ?></td>
                                <td><?php echo $item['meter_akhir']; ?></td>
                                <?php if ($this->session->userdata('role') === 'admin') : ?>
                                    <td>
                                        <a href="<?php echo base_url('penggunaan/edit/' . $item['id_penggunaan']); ?>" class="btn btn-info mb-3"><i class="fas fa-edit fa-sm text-white-50"></i></a> |
                                        <a href="javascript:void(0);" class="btn btn-danger mb-3 btn-delete" data-id="<?php echo $item['id_penggunaan']; ?>"><i class="fas fa-trash fa-sm text-white-50"></i></a>
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


<!-- Modal Tambah Penggunaan baru -->
<div class="modal fade" id="tambahPenggunaanModal" tabindex="-1" role="dialog" aria-labelledby="tambahPenggunaanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahPenggunaanModalLabel">Tambah Penggunaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('penggunaan/create'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="id_pelanggan" class="form-label">Pelanggan</label>
                        <select class="form-control" id="id_pelanggan" name="id_pelanggan">
                            <?php foreach ($pelanggan as $p) : ?>
                                <option value="<?= $p['id_pelanggan']; ?>"><?= $p['nama_pelanggan']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="bulan" class="form-label">Bulan</label>
                        <input type="month" class="form-control form-control-user" id="bulan" name="bulan" placeholder="Masukkan Nama Pelanggan">
                    </div>
                    <div class="form-group">
                        <label for="meter_awal" class="form-label">Meter Awal</label>
                        <input type="text" class="form-control form-control-user" id="meter_awal" name="meter_awal" placeholder="Masukkan Alamat">
                    </div>
                    <div class="form-group">
                        <label for="meter_akhir" class="form-label">Meter Akhir</label>
                        <input type="text" class="form-control form-control-user" id="meter_akhir" name="meter_akhir" placeholder="Masukkan Alamat">
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
<!-- End of Modal Tambah Penggunaan -->

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
                Apakah Anda yakin ingin menghapus penggunaan ini?
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
            $('#confirmDelete').attr('href', '<?= base_url('penggunaan/delete/') ?>' + id);
            $('#deleteModal').modal('show');
        });
    });
</script>