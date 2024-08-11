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
            <strong>Edit Tarif</strong>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form action="<?= base_url('tarif/update/' . $tarif['id_tarif']); ?>" method="post" enctype="multipart/form-data">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <tr>
                            <td> Masukan Daya</td>
                            <td> : </td>
                            <td> <input type="text" name="daya" value="<?php echo $tarif['daya']; ?>"> </td>
                        </tr>
                        <tr>
                            <td> Masukan Tarif per kWh</td>
                            <td> : </td>
                            <td> <input type="text" name="tarifperkwh" value="<?php echo $tarif['tarifperkwh']; ?>"> </td>
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