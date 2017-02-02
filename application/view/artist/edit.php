<h2><?= htmlentities(ucfirst($this->artist->name)); ?> bewerken</h2>

<div class="content">
    <form action="<?= URL; ?>artist/editPOST" method="POST">
        <input type="hidden" name="id" value="<?= $this->artist->id; ?>">
        <table>
            <thead>
                <tr>
                    <th>Gegevens</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody class="no-link">
                <tr>
                    <td><label>Naam</label></td>
                    <td><input type="text" name="name" value="<?= htmlentities($this->artist->name); ?>"></td>
                </tr>
                <tr>
                    <td><label>Beschrijving</label></td>
                    <td><textarea name="description"><?= htmlentities($this->artist->description); ?></textarea></td>
                </tr>
            </tbody>
        </table>
        
        <input type="submit" name="submit" value="Opslaan">
    </form>
</div>
