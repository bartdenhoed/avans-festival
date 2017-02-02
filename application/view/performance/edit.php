<h2>Optreden bewerken</h2>

<div class="content">
    <form action="<?= URL; ?>performance/editPOST/" method="POST">
        <input type="hidden" name="id" value="<?= $this->performance->id; ?>">
        <table>
            <thead>
                <tr>
                    <th>Gegevens</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody class="no-link">
                <tr>
                    <td><label>Artiest</label></td>
                    <td>
                        <select name="artist" required>
                            <?php foreach ($this->artists as $artist): ?>
                                <option value="<?= $artist->id; ?>" <?= (($this->performance->artist_id == $artist->id) ? 'selected' : '') ?>><?= htmlentities(ucfirst($artist->name)); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label>Podium</label></td>
                    <td>
                        <select name="stage" required>
                            <?php foreach ($this->stages as $stage): ?>
                                <option value="<?= $stage->id; ?>" <?= (($this->performance->stage_id == $stage->id) ? 'selected' : '') ?>><?= htmlentities(ucfirst($stage->name)); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label>Begin tijd</label></td>
                    <td><input type="time" name="time_start" value="<?= $this->performance->time_start; ?>" required></td>
                </tr>
                <tr>
                    <td><label>Eind tijd</label></td>
                    <td><input type="time" name="time_stop" value="<?= $this->performance->time_stop; ?>" required></td>
                </tr>
            </tbody>
        </table>


        <input type="submit" name="submit" value="Opslaan">
    </form>
</div>
