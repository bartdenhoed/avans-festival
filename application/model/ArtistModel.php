<?php

/**
 * Artist model contains all function to manipulate data for artists
 */
class ArtistModel
{
    /**
     * Get all artists from database
     */
    public static function getAllArtists()
    {
        $db = Database::getDatabase()->getConnection();

        $sql = 'SELECT id, name
        FROM artists
        WHERE deleted IS NULL
        ORDER BY name';
        $query = $db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    /**
     * Get artist by ID from database
     */
    public static function getArtist($id)
    {
        $db = Database::getDatabase()->getConnection();

        $sql = 'SELECT id, name, description
                FROM artists
                WHERE id = ? AND deleted IS NULL
                LIMIT 1';
        $query = $db->prepare($sql);
        $query->execute(array($id));

        return $query->fetch();
    }

    /**
     * Add new artist in database
     */
    public static function addArtist($data)
    {
        // Check required fields have data
		if (strlen($data['name']) == 0) {
			return false;
		}

        $db = Database::getDatabase()->getConnection();

        $sql = 'INSERT INTO artists (name, description)
                VALUES (?, ?)';
        $query = $db->prepare($sql);
        $params = array(
            $data['name'],
            $data['description']
        );

        $query->execute($params);

        if ($query->rowCount() == 1) {
			return $db->lastInsertId();
		}

        return false;
    }

    /**
     * Edit artist by ID in database
     */
    public static function editArtist($data)
    {
        // Check required fields have data
		if (
            strlen($data['id']) == 0 ||
            strlen($data['name']) == 0
        ) {
			return false;
		}

        $db = Database::getDatabase()->getConnection();

        $sql = 'UPDATE artists
                SET name = ?, description = ?, updated_timestamp = ?
                WHERE id = ?';
        $query = $db->prepare($sql);
        $params = array(
            $data['name'],
            $data['description'],
            date('Y-m-d H:i:s'),
            $data['id']
        );

        $query->execute($params);

        if ($query->rowCount() != 1) {
            return false;
		}

        return true;
    }

    /**
     * Delete artist by ID in database
     */
    public function deleteArtist($id)
    {
        // Check required fields have data
		if (strlen($id) == 0) {
			return false;
		}

        $db = Database::getDatabase()->getConnection();

        // Delete all performances from this artist
        $sql = 'UPDATE performances
                SET deleted = 1
                WHERE artist_id = ?';
        $query = $db->prepare($sql);
        $params = array($id);

        $query->execute($params);

        // Delete artist
        $sql = 'UPDATE artists
                SET deleted = 1
                WHERE id = ?';
        $query = $db->prepare($sql);
        $params = array($id);

        $query->execute($params);

        if ($query->rowCount() != 1) {
            return false;
		}

        return true;
    }
}
