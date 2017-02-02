<h2><?= $this->stage->name; ?> verwijderen</h2>

<div class="content">
    <p>Weet jezeker dat je dit podium wilt verwijderen?</p>
    <a href="<?= URL . 'stage/details/' . $this->stage->id; ?>" class="button">Annuleren</a>
    <a href="<?= URL . 'stage/deleteGET/' . $this->stage->id; ?>" class="button">Verwijderen</a>
</div>
