<?php

class StatusModel extends AppModel
{

    public static function getAll($status_id = null)
    {

        $sql = 'SELECT * FROM status ';
        if ($status_id) {
            $sql .= 'WHERE id = ?';
        }
        return self::getDB()->rows($sql, array($status_id));
    }

}
