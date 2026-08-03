<?php

class LogActiveModel extends z_model
{

    public function getLogByidAndType($id, $type): array
    {
        $sql = "SELECT * FROM `log_active` WHERE `active_id` = ? AND `active_type` = ? ORDER BY `date` ASC";
        return $this->exec($sql, "is", $id, $type)->resultToArray();
    }
}
