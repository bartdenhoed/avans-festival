<h2><?= $this->artist->name; ?> verwijderen</h2>

<div class="content">
    <p>Weet jezeker dat je deze band/artiest wilt verwijderen?</p>
    <a href="<?= URL . 'artist/details/' . $this->artist->id; ?>" class="button">Annuleren</a>
    <a href="<?= URL . 'artist/deleteGET/' . $this->artist->id; ?>" class="button">Verwijderen</a>
</div>
