<?php
include 'auth/conexion_be.php';

$column_name = 'usuario_id';
$table_name = 'reservas';

// Check if the column exists
$check_column_sql = "SHOW COLUMNS FROM $table_name LIKE '$column_name'";
$result = $conn->query($check_column_sql);

if ($result && $result->num_rows == 0) {
    // Column does not exist, add it
    $add_column_sql = "ALTER TABLE $table_name ADD COLUMN $column_name INT(6) UNSIGNED AFTER id";
    if ($conn->query($add_column_sql) === TRUE) {
        echo "Column '$column_name' added successfully to table '$table_name'.";
    } else {
        echo "Error adding column '$column_name': " . $conn->error;
    }
} else if ($result) {
    echo "Column '$column_name' already exists in table '$table_name'.";
} else {
    echo "Error checking for column '$column_name': " . $conn->error;
}

$conn->close();
?>