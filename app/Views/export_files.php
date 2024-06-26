<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">


    <div class="container-xl px-4">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <div class="my-3">
                        <?php if (session()->getFlashdata('error')) : ?>
                            <div class="alert alert-danger mt-3 alert-dismissible fade show">
                                <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>
                        <?php if (session()->getFlashdata('message')) : ?>
                            <div class="alert alert-success mt-3 alert-dismissible fade show">
                                <?= session()->getFlashdata('message') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="file-text"></i></div>
                        Export Files
                    </h1>
                    <div class="page-header-subtitle">An extension of the Simple DataTables library, customized for SB Admin Pro</div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Main page content-->
<div class="container-xl px-4 mt-n10">

    <!-- <a href="/process" class="btn btn-success my-1">Export All Files</a> -->
    <div class="card mb-4">
        <div class="card-header">Extended DataTables</div>
        <div class="card-body overflow-auto">
            <form action="<?=  base_url('process') ?>" method="post">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="bulan" class="form-label">Bulan</label>
                            <select class="form-select" id="bulan" name="bulan" required>
                                <option value="" selected disabled>Pilih Bulan</option>
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="tahun" class="form-label">Tahun</label>
                            <select class="form-select" id="tahun" name="tahun" required>
                                <option value="" selected disabled>Pilih Tahun</option>
                                <?php
                                $currentYear = date('Y');
                                for ($year = $currentYear; $year >= 2000; $year--) {
                                    echo "<option value=\"$year\">$year</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Proses Semua Data</button>
            </form>
        </div>
    </div>

</div>
<?= $this->endSection() ?>