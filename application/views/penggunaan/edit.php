<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="clearfix">
        <div class="float-left">
            <h1 class="h3 m-0 text-gray-800">Edit Tarif</h1>
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
            <strong>Edit Penggunaan</strong>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form action="<?= base_url('penggunaan/update/' . $penggunaan['id_penggunaan']); ?>" method="post" enctype="multipart/form-data">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <tr>
                            <td> Pelanggan</td>
                            <td> : </td>
                            <td>
                                <select class="form-control" id="id_pelanggan" name="id_pelanggan">
                                    <?php foreach ($pelanggan as $p) : ?>
                                        <option value="<?= $p['id_pelanggan']; ?>" <?= ($p['id_pelanggan'] == $penggunaan['id_pelanggan']) ? 'selected' : ''; ?>>
                                            <?= $p['nama_pelanggan']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Bulan</td>
                            <td>: </td>
                            <td><input type="month" name="bulan" value="<?= $penggunaan['tahun'] . '-' . $penggunaan['bulan'] ?>"> </td>
                        </tr>
                        <tr>
                            <td>Meter Awal</td>
                            <td> : </td>
                            <td> <input type="text" name="meter_awal" value="<?php echo $penggunaan['meter_awal']; ?>"> </td>
                        </tr>
                        <tr>
                            <td>Meter Akhir</td>
                            <td> : </td>
                            <td> <input type="text" name="meter_akhir" value="<?php echo $penggunaan['meter_akhir']; ?>"> </td>
                        </tr>
                        <tr>
                            <td colspan="3" align="center">
                                <input type="submit" name="btnsubmit" value="SIMPAN">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->