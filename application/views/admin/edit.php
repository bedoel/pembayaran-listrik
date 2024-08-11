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
            <strong>Edit Admin</strong>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form action="<?= base_url('admin/update/' . $admin['id_user']); ?>" method="post" enctype="multipart/form-data">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <tr>
                            <td> Username</td>
                            <td> : </td>
                            <td> <input type="text" name="username" value="<?php echo $admin['username']; ?>"> </td>
                        </tr>
                        <tr>
                            <td> Password Baru</td>
                            <td> : </td>
                            <td> <input type="password" name="password" placeholder="Masukkan password baru (jika ingin diubah)"> </td>
                        </tr>
                        <tr>
                            <td> Nama Admin</td>
                            <td> : </td>
                            <td> <input type="text" name="nama_admin" value="<?php echo $admin['nama_admin']; ?>"> </td>
                        </tr>
                        <tr>
                            <td> Level</td>
                            <td> : </td>
                            <td>
                                <select class="form-control" id="id_level" name="id_level">
                                    <?php foreach ($level as $l) : ?>
                                        <option value="<?= $l['id_level']; ?>" <?= ($l['id_level'] == $admin['id_level']) ? 'selected' : ''; ?>>
                                            <?= $l['nama_level']; ?>
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