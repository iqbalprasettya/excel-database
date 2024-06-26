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
                        <div class="page-header-icon"><i data-feather="bookmark"></i></div>
                        Upload FIles
                    </h1>
                    <div class="page-header-subtitle">An extension of the Simple DataTables library, customized for SB Admin Pro</div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Main page content-->
<div class="container-xl px-4 mt-n10">
    <div class="card mb-4">
        <div class="card-header">Extended DataTables</div>
        <div class="card-body overflow-auto">
            <form action="<?= base_url('upload') ?>" method="post" enctype="multipart/form-data">
                <label for="exampleFormControlInput1" class="form-label mt-3">File Excel</label>
                <input class="form-control" type="file" name="file" accept=".xlsx, .xls">
                <button type="submit" class="btn btn-success my-3">Upload</button>
            </form>
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th scope="col">No Bukti Potong</th>
                        <th scope="col">Penerima Penghasilan</th>
                        <th scope="col">ID Sistem</th>
                        <th scope="col">NIK</th>
                        <th scope="col">Tahun</th>
                        <th scope="col">Bulan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($allData) && !empty($allData)) : ?>
                        <?php foreach ($allData as $data) : ?>
                            <tr>
                                <td><span class="badge bg-primary"><?= $data['NO_BUKTI_POTONG']; ?></span></td>
                                <td><?= $data['NAMA_PENERIMA_PENGHASILAN']; ?></td>
                                <td><span class="badge bg-success"><?= $data['ID_SISTEM']; ?><span></td>
                                <td><?= $data['NIK']; ?></td>
                                <td><?= $data['TAHUN']; ?></td>
                                <td><?= $data['BULAN']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6" class="text-center">No data found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>