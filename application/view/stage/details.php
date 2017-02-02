<h2><?= htmlentities(ucfirst($this->stage->name)); ?></h2>

<div class="content">
    <?php if ($this->stage->description): ?>
        <p><strong>Beschrijving:</strong> <?= htmlentities(ucfirst($this->stage->description)); ?></p>
    <?php else: ?>
        <p>Geen beschrijving beschikbaar.</p>
    <?php endif; ?>

    <a href="<?= URL . 'stage/edit/' . $this->stage->id; ?>" class="button">Bewerken</a>
    <a href="<?= URL . 'stage/delete/' . $this->stage->id; ?>" class="button">Verwijderen</a>
</div>

<h2>Optredens:</h2>

<div class="content">
    <?php if ($this->performances): ?>
        <table>
            <thead>
                <tr>
                    <th>Tijd</th>
                    <th>Band/artiest</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($this->performances as $performance): ?>
                    <tr>
                        <td><a href="<?= URL . 'performance/details/' . $performance->id; ?>"><?= $performance->time_start . ' - ' . $performance->time_stop; ?></a></td>
                        <td><a href="<?= URL . 'performance/details/' . $performance->id; ?>"><?= htmlentities(ucfirst($performance->name)); ?></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Geen optredens gevonden.</p>
    <?php endif; ?>

    <a href="<?= URL . 'performance/add/stage/' . $this->stage->id; ?>" class="button">Nieuw optreden</a>
</div>
