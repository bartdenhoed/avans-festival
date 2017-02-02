<h2><?= htmlentities(ucfirst($this->performance->stage_name)) . ': ' . $this->performance->time_start . ' - ' . $this->performance->time_stop; ?></h2>

<div class="content">
    <p><a href="<?= URL . 'performance/edit/' . $this->performance->id; ?>" class="button">Bewerken</a>
    <a href="<?= URL . 'performance/delete/' . $this->performance->id; ?>" class="button">Verwijderen</a></p>

    <table>
        <thead>
            <tr>
                <th>Gegevens</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody class="no-link">
            <tr>
                <td>Podium</td>
                <td><?= htmlentities(ucfirst($this->performance->stage_name)); ?></td>
            </tr>
            <tr>
                <td>Podium beschrijving</td>
                    <td><?= ($this->performance->stage_description ? htmlentities(ucfirst($this->performance->stage_description)) : '-'); ?></td>
            </tr>
            <tr>
                <td>Tijd</td>
                <td><?= $this->performance->time_start . ' - ' . $this->performance->time_stop; ?></td>
            </tr>
            <tr>
                <td>Band/artiest</td>
                <td><?= htmlentities(ucfirst($this->performance->artist_name)); ?></td>
            </tr>
            <tr>
                <td>Band/artiest beschrijving</td>
                <td><?= ($this->performance->artist_description ? htmlentities(ucfirst($this->performance->artist_description)) : '-'); ?></td>
            </tr>
        </tbody>
    </table>

    <?php if ($this->previous_performance): ?>
    <a href="<?= URL . 'performance/details/' . $this->previous_performance; ?>" class="button">Vorige optreden</a>
    <?php endif; ?>

    <?php if ($this->next_performance): ?>
    <a href="<?= URL . 'performance/details/' . $this->next_performance; ?>" class="button">Volgende optreden</a>
    <?php endif; ?>

</div>
