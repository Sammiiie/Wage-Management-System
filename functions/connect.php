<?php
include "db.php";

//session_start();
// include('../vendor/autoload.php');

function dd($value)
{ // to be deleted
    echo "<pre>", print_r($value, true), "</pre>";
    die();
}

/**
 * @param $value
 */
function ddA($value)
{ // to be deleted
    echo "<pre>", print_r($value, true), "</pre>";
}

/**
 * @param $sql
 * @param array $data
 * @return false|mysqli_stmt
 */
function executeQuery($sql, $data = [])
{
    global $connection;
    if($stmt = $connection->prepare($sql)){
        if (!empty($data)) {
            $values = array_values($data);
            $types = str_repeat('s', count($values));
            $stmt->bind_param($types, ...$values);
        }
        $stmt->execute();
    }else{
        $stmt = var_dump($connection->error);
    }
    return $stmt;
}
function executeQuery2($sql, $data = [])
{
    global $connection;
    if($stmt = $connection->prepare($sql)){
        if (!empty($data)) {
            $values = array_values($data);
            $types = str_repeat('s', count($values)+1);
            $stmt->bind_param($types, ...$values);
        }
        $stmt->execute();
    }else{
        $stmt = var_dump($connection->error);
    }
    return $stmt;
}

/**
 * @param $table
 * @param array $conditions
 * @return mixed
 */
function selectAll($table, $conditions = [])
{
    global $connection;
    $sql = "SELECT * FROM $table";
    if (empty($conditions)) {
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    } else {
        $i = 0;
        foreach ($conditions as $key => $value) {
            if ($i === 0) {
                $sql = $sql . " WHERE $key=?";
            } else {
                $sql = $sql . " AND $key=?";
            }
            $i++;
        }

        $stmt = executeQuery($sql, $conditions);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}


/**
 * @param $table
 * @param array $conditions
 * @return mixed
 */
function selectAllWithOr($table, $conditions = [], $orField, $orValue)
{
    global $connection;
    $sql = "SELECT * FROM $table";
    if (empty($conditions)) {
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    } else {
        $i = 0;
        foreach ($conditions as $key => $value) {
            if ($i === 0) {
                $sql = $sql . " WHERE $key=?";
            } else {
                $sql = $sql . " AND $key=?";
            }
            $i++;
        }

        $sql = $sql . " OR " . $orField . "=" . $orValue;

        $stmt = executeQuery($sql, $conditions);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}


/**
 * @param $table
 * @param $conditions
 * @return array|null
 */
function selectOne($table, $conditions)
{
    global $connection;
    $sql = "SELECT * FROM $table";

    $i = 0;
    foreach ($conditions as $key => $value) {
        if ($i === 0) {
            $sql = $sql . " WHERE $key=?";
        } else {
            $sql = $sql . " AND $key=?";
        }
        $i++;
    }

    $sql = $sql . " LIMIT 1";

    $stmt = executeQuery($sql, $conditions);
    return $stmt->get_result()->fetch_assoc();
}
/**
 * @param $table
 * @param $conditions
 * @return array|null
 */
function selectOneOrderByDescLimit($table, $column, $order_data)
{
    global $connection;
    $sql = "SELECT $column FROM $table";

    $sql = $sql . " ORDER BY $order_data DESC LIMIT 1";

    $stmt = executeQuery($sql);
    return $stmt->get_result()->fetch_assoc();
}

function selectOneByIntID($table, $column, $search_parameter)
{
    global $connection;
    $sql = "SELECT $column FROM $table";

    $sql = $sql . " WHERE int_id = $search_parameter";

    $stmt = executeQuery($sql);
    return $stmt->get_result()->fetch_assoc();
}


/**
 * @param $table
 * @param $conditions
 * @return array|null
 */
function selectAllWithOrder($table, $conditions, $orderCondition, $orderType)
{
    $orderType = strtoupper($orderType);
    $table = strtolower($table);
    global $connection;
    $sql = "SELECT * FROM $table";

    $i = 0;
    foreach ($conditions as $key => $value) {
        if ($i === 0) {
            $sql = $sql . " WHERE $key=?";
        } else {
            $sql = $sql . " AND $key=?";
        }
        $i++;
    }

    $sql = $sql . " ORDER BY $orderCondition $orderType";
    $stmt = executeQuery($sql, $conditions);
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}


/**
 * @param $table
 * @param $pickConditions
 * @param array $conditions
 * @return array|mixed|null
 */
function selectSpecificData($table, $pickConditions, $conditions = [])
{
    global $connection;
    $sql = "SELECT";
    $increamental = 0;
    foreach ($pickConditions as $value) {
        if ($increamental === 0) {
            $sql = $sql . " $value";
        } else {
            $sql = $sql . ", $value";
        }
        $increamental++;
    }
    $sql = $sql . " FROM $table";

    if (empty($conditions)) {
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    } else {
        $i = 0;
        foreach ($conditions as $key => $value) {
            if ($i === 0) {
                $sql = $sql . " WHERE $key=?";
            } else {
                $sql = $sql . " AND $key=?";
            }
            $i++;
        }
    }

    $sql = $sql . " LIMIT 1";

    $stmt = executeQuery($sql, $conditions);
    return $stmt->get_result()->fetch_assoc();
}




/**
 * @param $table
 * @param $pickConditions
 * @param array $conditions
 * @return array|mixed|null
 */
function selectAllSpecificData($table, $pickConditions, $conditions = [])
{
    global $connection;
    $sql = "SELECT";
    $increamental = 0;
    foreach ($pickConditions as $value) {
        if ($increamental === 0) {
            $sql = $sql . " $value";
        } else {
            $sql = $sql . ", $value";
        }
        $increamental++;
    }
    $sql = $sql . " FROM $table";

    if (empty($conditions)) {
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    } else {
        $i = 0;
        foreach ($conditions as $key => $value) {
            if ($i === 0) {
                $sql = $sql . " WHERE $key=?";
            } else {
                $sql = $sql . " AND $key=?";
            }
            $i++;
        }
    }

    $stmt = executeQuery($sql, $conditions);
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

/**
 * @param $table
 * @param $conditions
 * @return array|null
 */
function checkLoanArrears($table, $conditions)
{
    global $connection;
    $sql = "SELECT * FROM $table";

    $i = 0;
    foreach ($conditions as $key => $value) {
        if ($i === 0) {
            $sql = $sql . " WHERE $key=?";
        } else {
            $sql = $sql . " AND $key=?";
        }
        $i++;
    }

    $sql = $sql . " AND installment >= '1' ORDER BY id ASC LIMIT 1";
    $stmt = executeQuery($sql, $conditions);
    return $stmt->get_result()->fetch_assoc();
}

/**
 * @param $table
 * @param $data
 * @return int
 */
function create($table, $data)
{
    global $connection;
    $sql = "INSERT INTO $table SET ";

    $i = 0;
    foreach ($data as $key => $value) {
        if ($i === 0) {
            $sql = $sql . " $key=?";
        } else {
            $sql = $sql . ", $key=?";
        }
        $i++;
    }
    $stmt = executeQuery($sql, $data);
    $id = $stmt->insert_id;
    return $id;
}

/**
 * @param $table
 * @param $id
 * @param $conName
 * @param $data
 * @return int
 */
function update($table, $id, $conName, $data)
{
    $sql = "UPDATE $table SET ";
    $i = 0;
    foreach ($data as $key => $value) {
        if ($i === 0) {
            $sql = $sql . " $key=?";
        } else {
            $sql = $sql . ", $key=?";
        }
        $i++;
    }

    $sql = $sql . " WHERE " . $conName . "=?";
    $data[$conName] = $id;
    $stmt = executeQuery($sql, $data);
    return $stmt->affected_rows;
}

/**
 * @param $table
 * @param $id
 * @return int
 */
function delete($table, $id, $consName)
{
    $sql = "DELETE FROM $table WHERE " . $consName . "=?";
    $stmt = executeQuery($sql, [$consName => $id]);
    return $stmt->affected_rows;
}

/**
 * @param $table
 * @return mixed
 */
function countRecords($table)
{
    global $connection;
    $sql = "SELECT COUNT(*) AS count FROM $table";
    $stmt = executeQuery($sql);
    $result = $stmt->get_result()->fetch_assoc();
    return $result['count'];
}

function sumRecords($sum, $table)
{
    global $connection;
    $sql = "SELECT SUM($sum) FROM $table";
    $stmt = executeQuery($sql);
    $result = $stmt->get_result()->fetch_assoc();
    return $result["SUM($sum)"];
}

function sumRecordsWhere($sum, $table, $condition)
{
    global $connection;
    $sql = "SELECT SUM($sum) FROM $table WHERE staff_id = '$condition'";
    $stmt = executeQuery($sql);
    $result = $stmt->get_result()->fetch_assoc();
    return $result["SUM($sum)"];
}
function sumRecordsWhere2($sum, $table, $condition)
{
    global $connection;
    $sql = "SELECT SUM($sum) FROM $table WHERE Name_of_State = '$condition'";
    $stmt = executeQuery($sql);
    $result = $stmt->get_result()->fetch_assoc();
    return $result["SUM($sum)"];
}
function countRecordsWhere($sum, $table, $condition)
{
    global $connection;
    $sql = "SELECT COUNT($sum) FROM $table WHERE State = '$condition'";
    $stmt = executeQuery($sql);
    $result = $stmt->get_result()->fetch_assoc();
    return $result["COUNT($sum)"];
}

// function to insert a new row into an arbitrary table, with the columns filled with the values 
// from an associative array and completely SQL-injection safe

function insert($table, $record) {
    global $connection;
    $cols = array();
    $vals = array();
    foreach (array_keys($record) as $col) $cols[] = sprintf("`%s`", $col);
    foreach (array_values($record) as $val) $vals[] = sprintf("'%s'", mysqli_real_escape_string($connection, $val));

    mysqli_query($connection, sprintf("INSERT INTO `%s`(%s) VALUES(%s)", $table, implode(", ", $cols), implode(", ", $vals)));

    return mysqli_insert_id($connection);
}

function selectAllGreater($table, $conditions = [])
{
    global $connection;
    $sql = "SELECT * FROM $table";
    if (empty($conditions)) {
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    } else {
        $i = 0;
        foreach ($conditions as $key => $value) {
            if ($i === 0) {
                $sql = $sql . " WHERE $key>=?";
            } else {
                $sql = $sql . " AND $key>=?";
            }
            $i++;
        }

        $stmt = executeQuery($sql, $conditions);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}

function selectAllLess($table, $conditions = [])
{
    global $connection;
    $sql = "SELECT * FROM $table";
    if (empty($conditions)) {
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    } else {
        $i = 0;
        foreach ($conditions as $key => $value) {
            if ($i === 0) {
                $sql = $sql . " WHERE $key>=?";
            } else {
                $sql = $sql . " AND $key<=?";
            }
            $i++;
        }

        $stmt = executeQuery($sql, $conditions);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}


function selectAllLessEq($table, $conditions, $dateConditions)
{
    global $connection;
    $sql = "SELECT * FROM $table";

    $i = 0;
    foreach ($conditions as $key => $value) {
        if ($i === 0) {
            $sql = $sql . " WHERE $key=?";
        } else {
            $sql = $sql . " AND $key=?";
        }
        $i++;
    }

    $s = 0;
    foreach ($dateConditions as $keys => $value) {
        if ($s === 0) {
            $sql = $sql . " AND $keys<=?";
        }else{
            $sql = $sql . " AND $keys<=?";
        }
        $s++;
    }
    $stmt = executeQuery($sql, array_merge($conditions, $dateConditions));
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}



// date functions to find individual components of date 
// and add or subtract from date
function getYear($date){
    $date = DateTime::createFromFormat("Y-m-d", $date);
    return $date->format("Y");
}

function getMonth($date){
    $date = DateTime::createFromFormat("Y-m-d", $date);
    return $date->format("m");
}

function getDay($date){
    $date = DateTime::createFromFormat("Y-m-d", $date);
    return $date->format("d");
}

function addYear($date, $period){
    $valueDate = date("Y-m-d", strtotime($date. "+$period year"));
    return $valueDate;
}

function addMonth($date, $period){
    $valueDate = date("Y-m-d", strtotime($date. "+$period month"));
    return $valueDate;
}

function addWeek($date, $period){
    $valueDate = date("Y-m-d", strtotime($date. "+$period week"));
    return $valueDate;
}

function addDay($date, $period){
    $valueDate = date("Y-m-d", strtotime($date. "+$period day"));
    return $valueDate;
}

function appendNumberNo($accountNo, $length){
    $appendedAccount = '******'.substr($accountNo, $length);
    return $appendedAccount;
}


