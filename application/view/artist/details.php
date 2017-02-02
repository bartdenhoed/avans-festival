<h2>Band/artiest: <?= htmlentities(ucfirst($this->artist->name)); ?></h2>

<div class="content">
    <?php if ($this->artist->description): ?>
        <p><strong>Beschrijving:</strong> <?= htmlentities(ucfirst($this->artist->description)); ?></p>
    <?php else: ?>
        <p>Geen beschrijving beschikbaar.</p>
    <?php endif; ?>

    <a href="<?= URL . 'artist/edit/' . $this->artist->id; ?>" class="button">Bewerken</a>
    <a href="<?= URL . 'artist/delete/' . $this->artist->id; ?>" class="button">Verwijderen</a>
</div>

<h2>Optredens:</h2>

<div class="content">
    <?php if ($this->performances): ?>
        <table>
            <thead>
                <tr>
                    <th>Tijd</th>
                    <th>Podium</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($this->performances as $performance): ?>
                    <tr>
                        <td><a href="<?= URL . 'performance/details/' . $performance->id; ?>"><?= $performance->time_start . ' - ' .$performance->time_stop; ?></a></td>
                        <td><a href="<?= URL . 'performance/details/' . $performance->id; ?>"><?= htmlentities(ucfirst($performance->name)); ?></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Geen optrends gevonden.</p>
    <?php endif; ?>

    <a href="<?= URL . 'performance/add/artist/' . $this->artist->id; ?>" class="button">Nieuw optreden</a>
</div>
