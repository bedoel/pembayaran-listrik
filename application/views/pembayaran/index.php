<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="clearfix">
        <div class="float-left">
            <h1 class="h3 m-0 text-gray-800">Pembayaran</h1>
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
            <strong>Pembayaran</strong>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama Pelanggan</th>
                            <th>Nomor KWH</th>
                            <th>Tanggal</th>
                            <th>Bulan Tagihan</th>
                            <th>Biaya Admin</th>
                            <th>Total Bayar</th>
                            <th>Nama Admin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pembayaran as $p) : ?>
                            <tr>
                                <td><?php echo $p['nama_pelanggan']; ?></td>
                                <td><?php echo $p['nomor_kwh']; ?></td>
                                <td><?php echo $p['tanggal_pembayaran']; ?></td>
                                <td><?php echo $p['bulan']; ?></td>
                                <td><?php echo $p['biaya_admin']; ?></td>
                                <td><?php echo $p['total_bayar']; ?></td>
                                <?php if (!$p['nama_admin']) : ?>
                                    <td><?php echo $p['nama_admin_copy']; ?></td>
                                <?php else : ?>
                                    <td><?php echo $p['nama_admin']; ?></td>
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