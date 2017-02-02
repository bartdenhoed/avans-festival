<h2>Bands & artiesten:</h2>

<div class="content">
    <?php if ($this->artists): ?>

        <table>
            <thead>
                <tr>
                    <th>Naam</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($this->artists as $artist): ?>
                    <tr>
                        <td><a href="<?= URL . 'artist/details/' . $artist->id; ?>"><?= htmlentities(ucfirst($artist->name)); ?></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Geen bands of artiesten gevonden.</p>
    <?php endif; ?>

    <a href="<?= URL; ?>artist/add" class="button">Toevoegen</a>
</div>

<h2>Podia:</h2>

<div class="content">
    <?php if ($this->stages): ?>
        <table>
            <thead>
                <tr>
                    <th>Naam</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($this->stages as $stage): ?>
                    <tr>
                        <td><a href="<?= URL . 'stage/details/' . $stage->id; ?>"><?= htmlentities(ucfirst($stage->name)); ?></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </tbody>
    </table>
    <?php else: ?>
        <p>Geen podia gevonden.</p>
    <?php endif; ?>

    <a href="<?= URL; ?>stage/add" class="button">Toevoegen</a>
</div>
