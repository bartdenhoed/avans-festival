<h2>Podium toevoegen</h2>

<div class="content">
    <form action="<?= URL; ?>stage/addPOST" method="POST">
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
                    <td><input type="text" name="name"></td>
                </tr>
                <tr>
                    <td><label>Beschrijving</label></td>
                    <td><textarea name="description"></textarea></td>
                </tr>
            </tbody>
        </table>

        <input type="submit" name="submit" value="Opslaan">
    </form>
</div>
