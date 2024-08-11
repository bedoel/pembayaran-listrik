<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="clearfix">
        <div class="float-left">
            <h1 class="h3 m-0 text-gray-800">Edit Pelanggan</h1>
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
            <strong>Edit Pelanggan</strong>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form action="<?= base_url('pelanggan/update/' . $pelanggan['id_pelanggan']); ?>" method="post" enctype="multipart/form-data">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <tr>
                            <td> Username</td>
                            <td> : </td>
                            <td> <input type="text" name="username" value="<?php echo $pelanggan['username']; ?>"> </td>
                        </tr>
                        <tr>
                            <td> Password Baru</td>
                            <td> : </td>
                            <td> <input type="password" name="password" placeholder="Masukkan password baru (jika ingin diubah)"> </td>
                        </tr>
                        <tr>
                            <td> Nomor kWh</td>
                            <td> : </td>
                            <td> <input type="text" name="nomor_kwh" value="<?php echo $pelanggan['nomor_kwh']; ?>" disabled> </td>
                        </tr>
                        <tr>
                            <td> Nama Pelanggan</td>
                            <td> : </td>
                            <td> <input type="text" name="nama_pelanggan" value="<?php echo $pelanggan['nama_pelanggan']; ?>"> </td>
                        </tr>
                        <tr>
                            <td> Alamat</td>
                            <td> : </td>
                            <td> <input type="text" name="alamat" value="<?php echo $pelanggan['alamat']; ?>"> </td>
                        </tr>
                        <tr>
                            <td> Daya</td>
                            <td> : </td>
                            <td>
                                <select class="form-control" id="id_tarif" name="id_tarif">
                                    <?php foreach ($tarif as $t) : ?>
                                        <option value="<?= $t['id_tarif']; ?>" <?= ($t['id_tarif'] == $pelanggan['id_tarif']) ? 'selected' : ''; ?>>
                                            <?= $t['daya']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
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