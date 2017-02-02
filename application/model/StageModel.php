<?php

/**
 * Stage model contains all function to manipulate data for stages
 */
class StageModel
{
    /**
     * Get all stages from database
     */
    public static function getAllStages()
    {
        $db = Database::getDatabase()->getConnection();

        $sql = 'SELECT id, name
                FROM stages
                WHERE deleted IS NULL
                ORDER BY name';
        $query = $db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    /**
     * Get stage by ID from database
     */
    public static function getStage($id)
    {
        $db = Database::getDatabase()->getConnection();

        $sql = 'SELECT id, name, description
                FROM stages
                WHERE id = ? AND deleted IS NULL
                LIMIT 1';
        $query = $db->prepare($sql);
        $query->execute(array($id));

        return $query->fetch();
    }

    /**
     * Add new stage in database
     */
    public static function addStage($data)
    {
        // Check required fields have data
		if (strlen($data['name']) == 0) {
			return false;
		}

        $db = Database::getDatabase()->getConnection();

        $sql = 'INSERT INTO stages (name, description)
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
     * Edit stage by ID in database
     */
    public static function editStage($data)
    {
        // Check required fields have data
		if (
            strlen($data['id']) == 0 ||
            strlen($data['name']) == 0
        ) {
			return false;
		}

        $db = Database::getDatabase()->getConnection();

        $sql = 'UPDATE stages
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
     * Delete stage by ID in database
     */
    public static function deleteStage($id)
    {
        // Check required fields have data
		if (strlen($id) == 0) {
			return false;
		}

        $db = Database::getDatabase()->getConnection();

        // Delete all performances from this stage
        $sql = 'UPDATE performances
                SET deleted = 1
                WHERE stage_id = ?';
        $query = $db->prepare($sql);
        $params = array($id);

        $query->execute($params);

        // Delete stage
        $sql = 'UPDATE stages
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
