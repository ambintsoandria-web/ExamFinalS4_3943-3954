<?= $this->extend('layout/navbar') ?>
<?= $this->section('content') ?>
<div class="deposit-wrap">
    <h1>Rajouter epargne</h1>
    <form action="<?= site_url('client/addEpargne') ?>" method="POST">
        <input type="text" name="pourcentage">
        <input type="submit">
    </form>
</div>
<?= $this->endSection() ?>