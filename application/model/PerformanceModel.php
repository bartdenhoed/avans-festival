<?php

/**
 * Performance model contains all function to manipulate data for performances
 */
class PerformanceModel
{
    /**
     * Get all performances by artist id from database
     */
    public static function getPerformancesByArtist($id)
    {
        $db = Database::getDatabase()->getConnection();

        $sql = 'SELECT p.id, DATE_FORMAT(p.time_start, "%H:%i") as time_start, DATE_FORMAT(p.time_stop, "%H:%i") as time_stop, s.id as stage_id, s.name, s.description
                FROM performances p
                LEFT JOIN stages s ON p.stage_id = s.id
                WHERE p.artist_id = ? AND p.deleted IS NULL AND s.deleted IS NULL
                ORDER BY p.time_start';
        $query = $db->prepare($sql);
        $query->execute(array($id));

        return $query->fetchAll();
    }

    /**
     * Get all performances by stage id from database
     */
    public static function getPerformancesByStage($id)
    {
        $db = Database::getDatabase()->getConnection();

        $sql = 'SELECT p.id, DATE_FORMAT(p.time_start, "%H:%i") as time_start, DATE_FORMAT(p.time_stop, "%H:%i") as time_stop, a.id as artist_id, a.name
                FROM performances p
                LEFT JOIN artists a ON p.artist_id = a.id
                WHERE p.stage_id = ? AND p.deleted IS NULL AND a.deleted IS NULL
                ORDER BY p.time_start';
        $query = $db->prepare($sql);
        $query->execute(array($id));

        return $query->fetchAll();
    }

    /**
     * Get performance by ID from database
     */
    public static function getPerformance($id)
    {
        $db = Database::getDatabase()->getConnection();

        $sql = 'SELECT p.id, p.artist_id, p.stage_id, DATE_FORMAT(p.time_start, "%H:%i") as time_start, DATE_FORMAT(p.time_stop, "%H:%i") as time_stop, s.name as stage_name, s.description as stage_description, a.name as artist_name, a.description as artist_description
                FROM performances p
                LEFT JOIN stages s ON p.stage_id = s.id
                LEFT JOIN artists a ON p.artist_id = a.id
                WHERE p.id = ? AND p.deleted IS NULL AND s.deleted IS NULL AND a.deleted IS NULL
                LIMIT 1';
        $query = $db->prepare($sql);
        $query->execute(array($id));

        return $query->fetch();
    }

    /**
     * Add new performance in database
     */
    public static function addPerformance($data)
    {
        // Check required fields have data
		if (
            strlen($data['artist'])     == 0 ||
            strlen($data['stage'])      == 0 ||
            strlen($data['time_start']) == 0 ||
            strlen($data['time_stop'])  == 0
        ) {
			return false;
		}

        $db = Database::getDatabase()->getConnection();

        // Check time start and time stop are valid and stage and artist is free
        if (
            !self::checkDuplicatePerformanceByArtist($data['artist'], $data['time_start'], $data['time_stop']) OR
            !self::checkDuplicatePerformanceByStage($data['stage'], $data['time_start'], $data['time_stop']) OR
            ($data['time_start'] >= $data['time_stop'])
        ) {
            return false;
        }

        $sql = 'INSERT INTO performances (artist_id, stage_id, time_start, time_stop)
                VALUES (?, ?, ?, ?)';
        $query = $db->prepare($sql);
        $params = array(
            $data['artist'],
            $data['stage'],
            $data['time_start'],
            $data['time_stop']
        );

        $query->execute($params);

        if ($query->rowCount() == 1) {
			return $db->lastInsertId();
		}

        return false;
    }

    /**
     * Edit performance by ID in database
     */
    public static function editPerformance($data)
    {
        // Check required fields have data
		if (
            strlen($data['id'])         == 0 ||
            strlen($data['artist'])     == 0 ||
            strlen($data['stage'])      == 0 ||
            strlen($data['time_start']) == 0 ||
            strlen($data['time_stop'])  == 0
        ) {
			return false;
		}

        $db = Database::getDatabase()->getConnection();

        // Check time start and time stop are valid and stage and artist is free
        if (
            !self::checkDuplicatePerformanceByArtist($data['artist'], $data['time_start'], $data['time_stop'], $data['id']) OR
            !self::checkDuplicatePerformanceByStage($data['stage'], $data['time_start'], $data['time_stop'], $data['id']) OR
            ($data['time_start'] >= $data['time_stop'])
        ) {
            return false;
        }

        $sql = 'UPDATE performances
                SET artist_id = ?, stage_id = ?, time_start = ?, time_stop = ?, updated_timestamp = ?
                WHERE id = ?';
        $query = $db->prepare($sql);
        $params = array(
            $data['artist'],
            $data['stage'],
            $data['time_start'],
            $data['time_stop'],
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
     * Get next performance from specific stage based on performance ID
     */
    public static function getNextPerformance($performanceId)
    {
        $db = Database::getDatabase()->getConnection();

        $sql = 'SELECT p.id FROM performances p
                LEFT JOIN stages s ON p.stage_id = s.id
                WHERE p.stage_id = (SELECT stage_id FROM performances WHERE id = :id) AND p.id > :id AND p.deleted IS NULL AND a.deleted IS NULL
                ORDER BY p.id ASC
                LIMIT 1';
        $query = $db->prepare($sql);
        $query->execute(array('id' => $performanceId));

        $result = $query->fetch();

        if ($result) {
            return $result->id;
        }

        return false;
    }

    /**
     * Get previous performance from specific stage based on performance ID
     */
    public static function getPreviousPerformance($performanceId)
    {
        $db = Database::getDatabase()->getConnection();

        $sql = 'SELECT p.id FROM performances p
                LEFT JOIN stages s ON p.stage_id = s.id
                WHERE p.stage_id = (SELECT stage_id FROM performances WHERE id = :id) AND p.id < :id AND p.deleted IS NULL AND a.deleted IS NULL
                ORDER BY p.id DESC
                LIMIT 1';
        $query = $db->prepare($sql);
        $query->execute(array('id' => $performanceId));

        $result = $query->fetch();

        if ($result) {
            return $result->id;
        }

        return false;
    }

    /**
     * Delete performance by ID in database
     */
    public static function deletePerformance($id)
    {
        // Check required fields have data
		if (strlen($id) == 0) {
			return false;
		}

        $db = Database::getDatabase()->getConnection();

        $sql = 'UPDATE performances
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

    /**
     * Check artist is free based in time start and time stop
     */
    private static function checkDuplicatePerformanceByArtist($artistId, $timeStart, $timeStop, $id = null)
    {
        $db = Database::getDatabase()->getConnection();

        $sql = 'SELECT * FROM performances
                WHERE artist_id = :artist_id AND deleted IS NULL AND
                    ((time_start >= :time_start AND time_stop <= :time_stop) OR
                    (time_start >= :time_start AND time_start <= :time_stop) OR
                    (time_stop >= :time_start AND time_stop <= :time_stop) OR
                    (time_start <= :time_start AND time_stop >= :time_stop))';
            if ($id) {
                $sql .= ' AND id != :id';
            }
            $sql .= ' LIMIT 1';
        $query = $db->prepare($sql);
        $query->execute(array(
            'artist_id' => $artistId,
            'time_start' => $timeStart,
            'time_stop' => $timeStop,
            'id' => $id
        ));

        $result = $query->fetch();

        if ($result) {
            return false;
        }

        return true;
    }

    /**
     * Check stage is free based in time start and time stop
     */
    private static function checkDuplicatePerformanceByStage($stageId, $timeStart, $timeStop, $id = null)
    {
        $db = Database::getDatabase()->getConnection();

        $sql = 'SELECT * FROM performances
                WHERE stage_id = :stage_id AND deleted IS NULL AND
                    ((time_start > :time_start AND time_stop < :time_stop) OR
                    (time_start > :time_start AND time_start < :time_stop) OR
                    (time_stop > :time_start AND time_stop < :time_stop) OR
                    (time_start < :time_start AND time_stop > :time_stop))';
                if ($id) {
                    $sql .= ' AND id != :id';
                }
                $sql .= ' LIMIT 1';
        $query = $db->prepare($sql);
        $query->execute(array(
            'stage_id' => $stageId,
            'time_start' => $timeStart,
            'time_stop' => $timeStop,
            'id' => $id
        ));

        $result = $query->fetch();

        if ($result) {
            return false;
        }

        return true;
    }
}
