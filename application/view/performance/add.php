<h2>Optreden toevoegen</h2>

<div class="content">
    <form action="<?= URL . 'performance/addPOST/' . $this->selector . '/' . $this->selectorId; ?>" method="POST">
        <table>
            <thead>
                <tr>
                    <th>Gegevens</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody class="no-link">
                <tr>
                    <td><label>Band/artiest</label></td>
                    <td>
                        <select name="artist" required>
                            <?php foreach ($this->artists as $artist): ?>
                                <?php if ($this->selector == 'artist'): ?>
                                    <option value="<?= $artist->id; ?>" <?= (($this->selectorId == $artist->id) ? 'selected' : '') ?>><?= htmlentities(ucfirst($artist->name)); ?></option>
                                <?php else: ?>
                                    <option value="<?= $artist->id; ?>"><?= htmlentities(ucfirst($artist->name)); ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label>Podium</label></td>
                    <td>
                        <select name="stage" required>
                            <?php foreach ($this->stages as $stage): ?>
                                <?php if ($this->selector == 'stage'): ?>
                                    <option value="<?= $stage->id; ?>" <?= (($this->selectorId == $stage->id) ? 'selected' : '') ?>><?= htmlentities(ucfirst($stage->name)); ?></option>
                                <?php else: ?>
                                    <option value="<?= $stage->id; ?>"><?= htmlentities(ucfirst($stage->name)); ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label>Begin tijd</label></td>
                    <td><input type="time" name="time_start" required></td>
                </tr>
                <tr>
                    <td><label>Eind tijd</label></td>
                    <td><input type="time" name="time_stop" required></td>
                </tr>
            </tbody>
        </table>

        <input type="submit" name="submit" value="Opslaan">
    </form>
</div>
