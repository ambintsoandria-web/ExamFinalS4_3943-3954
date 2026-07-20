<?= $this->extend('layout/navbar') ?>
<?= $this->section('content') ?>
<div class="deposit-wrap">
    <a class="deposit-back" href="<?= site_url('client/espace') ?>"><i class="bi bi-arrow-left"></i> Retour au
        compte</a>
    <section class="deposit-card">
        <div class="deposit-icon"><i class="bi bi-arrow-left-right"></i></div>
        <span class="page-kicker">Envoyer de l'argent</span>
        <h1>Faire un transfert</h1>
        <p class="deposit-lead">Saisissez le téléphone du destinataire et le montant.</p>
        <?php if (session('erreur')): ?>
            <div class="prefix-alert prefix-alert-error"><?= esc(session('erreur')) ?></div><?php endif; ?>
        <form action="<?= site_url('client/transfert') ?>" method="post" class="deposit-form">
            <?= csrf_field() ?>
            <label for="telephone">Téléphone du(es) destinataire(s)</label>
            <button type="button" class="add-recipient-button"><i class="bi bi-plus"></i> Ajouter un autre destinataire</button>
            <div id="recipients-container">
                <div class="recipient-input">
                    <input type="text" name="telephone[]" id="telephone" value="<?= esc(old('telephone')) ?>" placeholder="0340000000" required>
                    <button type="button" class="remove-recipient-button"><i class="bi bi-x"></i></button>
                </div>
            </div>
            <label for="montant" class="spaced-label">Montant</label>
            <div class="amount-input"><input type="number" name="montant" id="montant"
                    value="<?= esc(old('montant')) ?>" placeholder="10 000" required><span>Ar</span></div>
            <label class="checkbox-line">
                <input type="checkbox" name="ajouterfraisretrait" value="1" <?= old('ajouterfraisretrait') ? 'checked' : '' ?>>
                Ajouter les frais de retrait
            </label>
            <button type="submit" class="deposit-button">Envoyer <i class="bi bi-arrow-right"></i></button>
        </form>
    </section>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const addRecipientButton = document.querySelector('.add-recipient-button');
    const recipientsContainer = document.getElementById('recipients-container');

    addRecipientButton.addEventListener('click', function () {
        const recipientInput = document.createElement('div');
        recipientInput.classList.add('recipient-input');
        recipientInput.innerHTML = `
            <input type="text" name="telephone[]" placeholder="0340000000" required>
            <button type="button" class="remove-recipient-button"><i class="bi bi-x"></i></button>
        `;
        recipientsContainer.appendChild(recipientInput);
    });

    recipientsContainer.addEventListener('click', function (event) {
        const removeButton = event.target.closest('.remove-recipient-button');
        if (!removeButton) {
            return;
        }

        if (recipientsContainer.children.length === 1) {
            return;
        }

        removeButton.parentElement.remove();
    });
});
</script>
<?= $this->endSection() ?>