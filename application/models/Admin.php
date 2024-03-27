<?php

namespace application\models;

use application\core\Model;

class Admin extends Model
{

    private array $config;

    public function __construct()
    {
        parent::__construct();
        $this->config = require 'application/config/admin.php';
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    public function getViewData(string $section): array
    {
        $configSection = $this->config[$section];
        if ($configSection['view']['tree']) {
            $fields = array_keys($configSection['view']['fields']);
            $mainField = $fields[0];
            $fields = array_slice($fields, 1);
            if (count($fields) > 0) {
                $fieldList = ',' . implode(',', $fields);
                $fieldParentList = ',parent.' . implode(',parent.', $fields);
            } else
                $fieldList = $fieldParentList = '';
            $sql = "WITH RECURSIVE tree_view AS (
                        SELECT id, parent_id, 0 AS level, CAST(id AS CHAR(50)) AS order_sequence, $mainField $fieldList
                        FROM catalog_groups
                        WHERE parent_id = 0
                    UNION ALL
                        SELECT parent.id, parent.parent_id, level + 1 AS level, CONCAT(order_sequence , '_' , parent.id) AS order_sequence, parent.$mainField $fieldParentList
                        FROM catalog_groups parent
                        JOIN tree_view tv ON parent.parent_id = tv.id
                    )
                    SELECT id, CONCAT(LEFT('└───────────────', level), $mainField) AS $mainField $fieldList
                    FROM tree_view
                    ORDER BY order_sequence;";
        } else {
            $fields = '';
            foreach ($configSection['view']['fields'] as $key => $field) {
                if (isset($field['column']))
                    $fields .= $field['column'] . ' AS ' . $key . ',';
                else
                    $fields .= $key . ',';
            }
            $fields = rtrim($fields, ',');
            $sql = "SELECT {$this->config[$section]['table']}.id," . $fields . " FROM " .
                $this->config[$section]['table'] . ' ' .
                ($this->config[$section]['view']['join'] ?: '') . ' ' .
                ($this->config[$section]['view']['group'] ? 'GROUP BY ' . $this->config[$section]['view']['group'] : '') . ' ' .
                ($this->config[$section]['order'] ? 'ORDER BY ' . $this->config[$section]['order'] : '');
        }
        $dataTable = $this->db->row($sql);
        return ['config' => $configSection, 'dataTable' => $dataTable];
    }

    public function getEditData(string $section, ?int $id): array
    {
        $configSection = $this->config[$section]['edit'];
        $dataTable = $dataSelect = $selected = $multiImage = [];
        $fields = '';
        foreach ($configSection['fields'] as $key => $value) {
            if ($value['type'] == 'select') {
                $whereSql = '';
                if (isset($value['selectSQL']['where']))
                    $whereSql = ' WHERE ' . $value['selectSQL']['where'];
                if (isset($value['selectSQL']['excludeId']) && isset($id))
                    $whereSql .= ($whereSql ? ' AND ' : ' WHERE ') . ' id != ' . $id;
                $selectSql = 'SELECT ' . implode(',', $value['selectSQL']['fields']) . ' FROM ' . $value['selectSQL']['table'] . $whereSql . ($value['selectSQL']['order'] ? ' ORDER BY ' . $value['selectSQL']['order'] : '');
                $dataSelect[$key] = $this->db->row($selectSql);
            } elseif ($value['type'] == 'multiselect') {
                $dataSelect[$key] = $this->db->row("SELECT * FROM {$configSection['fields'][$key]['sourceTable']} ORDER BY name");
                $selected[$key] = $this->db->fullColumn("SELECT group_id FROM {$configSection['fields'][$key]['targetTable']} WHERE id = :id", ['id' => $id]);
                continue; // фиктивное поле исключается из запроса
            } elseif ($value['type'] == 'multiImage') {
                $multiImage[$key] = $this->db->pairColumn("SELECT id, name FROM {$configSection['fields'][$key]['targetTable']} WHERE group_id = :id", ['id' => $id]);
                continue;
            }
            $fields .= $key . ',';
        }
        $fields = rtrim($fields, ',');
        if ($id)
            $dataTable = $this->db->row("SELECT " . $fields . " FROM " . $this->config[$section]['table'] . " WHERE id = :id", ['id' => $id])[0];
        if (!empty($selected))
            $dataTable = array_merge($dataTable, $selected);
        return ['configEdit' => $configSection, 'dataRow' => $dataTable, 'dataSelect' => $dataSelect, 'multiImage' => $multiImage];
    }

    public function getImageNames(string $section, int $id): array
    {
        $images = [];
        $table = $this->config[$section]['table'];
        $row = $this->db->row("SELECT * FROM $table WHERE id = :id", ['id' => $id])[0];
        foreach ($this->config[$section]['edit']['fields'] as $key => $field) {
            if ($field['type'] == 'image' || $field['type'] == 'multiImage')
                $images[] = $row[$key];
        }
        return $images;
    }

    public function getImageName(string $table, int $id): array
    {
        $images[] = $this->db->column("SELECT name FROM $table WHERE id = :id", ['id' => $id]);
        return $images;
    }

    public function saveRow(string $table, ?int $id, array $fields, array $data, array $images): ?int
    {
        $set = $values = $fieldSql = '';
        $fieldNames = array_keys($fields);
        $params = [];
        foreach ($fieldNames as $field) {
            if ($fields[$field]['type'] == 'image')
                if ($images['images'][$field])
                    $data[$field] = $images['images'][$field];
                elseif (!$data['delete'][$field])
                    continue;
            if ($fields[$field]['type'] == 'checkbox' && $data[$field] == '')
                $data[$field] = 0;
            if (($fields[$field]['type'] == 'radio' || $fields[$field]['disabled']) && $data[$field] == '')
                continue;
            if ($fields[$field]['type'] == 'multiselect') {
                if ($id)
                    $this->db->query('DELETE FROM `' . $fields[$field]['targetTable'] . '` WHERE id = :id', ['id' => $id]);
                foreach ($data[$field] as $gr)
                    $this->db->query('INSERT INTO `' . $fields[$field]['targetTable'] . '` (id, group_id) VALUES ("' . $id . '", "' . $gr . '")');
                continue;
            }
            if ($fields[$field]['type'] == 'multiImage') {
                if (!empty($images['extImages'][$field]))
                    foreach ($images['extImages'][$field] as $extImage)
                        $this->db->query('INSERT INTO `' . $fields[$field]['targetTable'] . '` (group_id, name) VALUES ("' . $id . '", "' . $extImage . '")');
                continue;
            }
            $set .= "`$field` = :$field,";
            $fieldSql .= "`$field`,";
            $values .= ":$field,";
            $params[$field] = $data[$field];
        }
        $set = rtrim($set, ',');
        $values = rtrim($values, ',');
        $fieldSql = rtrim($fieldSql, ',');
        if ($id)
            $sql = 'UPDATE `' . $table . '` SET ' . $set . ' WHERE id = ' . $id;
        else
            $sql = 'INSERT INTO `' . $table . '` (' . $fieldSql . ') VALUES (' . $values . ')';
        if ($this->db->query($sql, $params))
            return ($id ?: $this->db->lastInsertId());
        else
            return null;
    }

    public function deleteRow(string $table, int $id): void
    {
        $this->db->query("DELETE FROM `$table` WHERE id = :id", ['id' => $id]);
    }

    public function authorization(string $login, string $password): array
    {
        $message = '';
        $row = $this->db->row("SELECT * FROM admin_users WHERE login = :login", ['login' => $login])[0];
        if (!$row) {
            $isSuccess = false;
            $message .= 'Неверный логин. ';
        } else {
            if (password_verify($password, $row['password_hash'])) {
                $isSuccess = true;
            } else {
                $isSuccess = false;
                $message .= 'Неверный пароль. ';
            }
        }
        return ['isSuccess' => $isSuccess, 'message' => $message, 'data' => $row];
    }

    public function getToken(int $id): string
    {
        $token = password_hash(time() . $id, PASSWORD_DEFAULT);
        $expired = date("Y-m-d H:i:s", strtotime("+ 5 days"));
        $this->db->query("UPDATE admin_users SET token = :token, token_valid_time = :expired WHERE id = :id", ['id' => $id, 'token' => $token, 'expired' => $expired]);
        return $token;
    }

    public function isAuthorizedByCookies(string $id, string $token): bool
    {
        $row = $this->db->row(
            "SELECT * FROM admin_users WHERE MD5(id) = :id AND token = :token AND token_valid_time > CURRENT_TIMESTAMP()",
            ['id' => $id, 'token' => $token])[0];
        if ($row) {
            $_SESSION['admin_id'] = $row['id']; // восстанавливаем основной сессионный ключ
            // продлеваем сессию на куках
            $expired = date("Y-m-d H:i:s", strtotime("+ 5 days"));
            $this->db->query("UPDATE admin_users SET token_valid_time = :expired WHERE id = :id", ['id' => $row['id'], 'expired' => $expired]);
            return true;
        } else
            return false;
    }

    public function createUser(string $login, string $password): void
    {
        $this->db->query(
            "INSERT INTO admin_users (login, password_hash) VALUES (:login, :password_hash)",
            ['login' => $login, 'password_hash' => password_hash($password, PASSWORD_DEFAULT)]
        );
    }

}