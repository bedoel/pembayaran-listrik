<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="clearfix">
        <div class="float-left">
            <h1 class="h3 m-0 text-gray-800">Tagihan</h1>
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
            <strong>Data Tagihan</strong>
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
                            <th>Jumlah Meter</th>
                            <?php if ($this->session->userdata('role') === 'pelanggan') : ?>
                                <th>Tarif per kWh</th>
                            <?php endif; ?>
                            <th>Total Pembayaran</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tagihan as $item) : ?>
                            <tr>
                                <td><?php echo $item['nama_pelanggan']; ?></td>
                                <td><?php echo $item['nomor_kwh']; ?></td>
                                <td><?php echo $item['bulan']; ?></td>
                                <td><?php echo $item['tahun']; ?></td>
                                <td><?php echo $item['jumlah_meter']; ?></td>
                                <?php if ($this->session->userdata('role') === 'pelanggan') : ?>
                                    <td><?php echo $item['tarifperkwh']; ?></td>
                                <?php endif; ?>
                                <td><?php echo $item['total_pembayaran']; ?></td>
                                <?php if ($this->session->userdata('role') === 'admin') : ?>
                                    <form action="<?= base_url('tagihan/update_status/' . $item['id_tagihan']); ?>" method="post">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <select class="custom-select mr-2" id="status" name="status">
                                                    <option value="Belum Bayar" <?= $item['status'] == 'Belum Bayar' ? 'selected' : '' ?>>Belum Bayar</option>
                                                    <option value="Lunas" <?= $item['status'] == 'Lunas' ? 'selected' : '' ?>>Lunas</option>
                                                </select>
                                                <button type="submit" class="btn btn-info"><i class="fas fa-save fa-sm text-white-50"></i></button>
                                            </div>
                                        </td>
                                    </form>
                                <?php else : ?>
                                    <td><?php echo $item['status']; ?></td>
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