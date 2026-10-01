<?php

class LogActiveModel extends z_model
{

    public function getLogByidAndType($id, $type): array
    {
        $sql = "SELECT *, `z_user`.email AS userEmail
                FROM `log_active` 
                JOIN `z_user` ON `log_active`.`userId` = `z_user`.`id`
                WHERE `active_id` = ? AND `active_type` = ? 
                ORDER BY `date` ASC";
        return $this->exec($sql, "is", $id, $type)->resultToArray();
    }
}
