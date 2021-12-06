<?php

/**
 * Query using Prepared Statement
 * 
 * Example:
 * 
 * $result = query($conn, $query, "ss", ["Bob", "Johnson"]);
 * 
 * returns array (
 *      0=> array('firstName' => 'Bob', 'lastName' => 'Johnson')
 * )
 * 
 * Reference: https://www.php.net/manual/en/mysqli.prepare.php#107200
 * @param mysqli $conn
 * @param string $query
 * @param string|null $type
 * @param array|null $params
 * @return array|ErrorException
 */
function query(mysqli $conn, string $query, ?string $type = null, ?array $params = null): array|Error
{
    $bindParams = array();
    // Hold value if Query Result is noy one
    $multiQuery = false;
    // Prepare SQL Query
    if ($stmt = mysqli_prepare($conn, $query)) {
        // Check Param that inserted
        if (!is_null($params) && is_array($params)) {
            if (count($params) == count($params, 1)) {
                $params = array($params);
                $multiQuery = false;
            } else {
                $multiQuery = true;
            }
        }

        // Check the type, not really know about the fancy code below
        if (!is_null($type)) {
            $bindParamsReferences = array();
            $bindParams = array_pad($bindParams, (count($params, 1) - count($params)) / count($params), "");
            foreach ($bindParams as $key => $value) {
                $bindParamsReferences[$key] = &$bindParams[$key];
            }
            array_unshift($bindParamsReferences, $type);
            $bindParamsMethod = new ReflectionMethod('mysqli_stmt', 'bind_param');
            $bindParamsMethod->invokeArgs($stmt, $bindParamsReferences);
        }

        $result = array();
        foreach ($params as $queryKey => $query) {
            foreach ($bindParams as $paramKey => $value) {
                $bindParams[$paramKey] = $query[$paramKey];
            }
            $queryResult = array();
            // Execute SQL Statement
            if (mysqli_stmt_execute($stmt)) {
                $resultMetaData = mysqli_stmt_result_metadata($stmt);
                if ($resultMetaData) {
                    $stmtRow = array();
                    $rowReferences = array();
                    while ($field = mysqli_fetch_field($resultMetaData)) {
                        $rowReferences[] = &$stmtRow[$field->name];
                    }
                    mysqli_free_result($resultMetaData);
                    $bindResultMethod = new ReflectionMethod('mysqli_stmt', 'bind_result');
                    $bindResultMethod->invokeArgs($stmt, $rowReferences);
                    while (mysqli_stmt_fetch($stmt)) {
                        $row = array();
                        foreach ($stmtRow as $key => $value) {
                            $row[$key] = $value;
                        }
                        $queryResult[] = $row;
                    }
                    mysqli_stmt_free_result($stmt);
                } else {
                    $queryResult[] = mysqli_stmt_affected_rows($stmt);
                }
            } else {
                $queryResult[] = false;
            }
            $result[$queryKey] = $queryResult;
        }
        mysqli_stmt_close($stmt);
    }
    // If SQL Prepare is Error
    else {
        // var_dump(mysqli_error($conn));
        $exception = new ErrorException(mysqli_error($conn));
        $result = false;
    }

    if ($multiQuery) {
        return $result;
    } else {
        if ($result !== false) {
            return $result[0];
        } else {
            throw new ErrorException("Error on executing query!", 0, 1, __FILE__, 53, $exception);
        }
    }
}
