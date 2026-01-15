<?php
include '../../auth/conexion_be.php';

$search = isset($_POST['search']) ? mysqli_real_escape_string($conn, $_POST['search']) : '';
$role_filter = isset($_POST['role']) ? mysqli_real_escape_string($conn, $_POST['role']) : 'all';

$where_clause = "WHERE 1=1";

if ($role_filter === 'guest') {
    $where_clause .= " AND (rol = 'Huésped' OR rol = 'guest')";
} elseif ($role_filter === 'admin') {
    $where_clause .= " AND (rol = 'Admin' OR rol = 'admin')";
}

if (!empty($search)) {
    $where_clause .= " AND (nombre LIKE '%$search%' OR apellido LIKE '%$search%' OR usuario LIKE '%$search%' OR email LIKE '%$search%')";
}

// Limitamos a 20 resultados para la búsqueda en tiempo real
$sql = "SELECT * FROM usuarios $where_clause ORDER BY reg_date DESC LIMIT 20";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $imagen = !empty($row['imagen']) ? (strpos($row['imagen'], 'assets/') === 0 ? '../../' . $row['imagen'] : '../../assets/img/usuarios/' . $row['imagen']) : 'https://ui-avatars.com/api/?name=' . urlencode($row['nombre'] . ' ' . $row['apellido']) . '&background=random';
        $rol_class = ($row['rol'] == 'Admin' || $row['rol'] == 'admin') ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300' : 'bg-gray-100 text-gray-700 dark:bg-gray-700/50 dark:text-gray-300';
        
        // Ensure ID is available for the delete modal
        $jsonData = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
        
        echo '
        <tr class="group hover:bg-background-light dark:hover:bg-gray-800 transition-colors">
            <td class="px-6 py-4 text-text-secondary dark:text-gray-400">#' . $row['id'] . '</td>
            <td class="px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="size-11 rounded-full bg-cover bg-center shrink-0 border border-gray-100 dark:border-gray-700 shadow-sm" style="background-image: url(\'' . $imagen . '\');"></div>
                    <span class="font-bold text-text-main dark:text-white">' . htmlspecialchars($row['nombre'] . ' ' . $row['apellido']) . '</span>
                </div>
            </td>
            <td class="px-6 py-4 text-text-secondary dark:text-gray-300">' . htmlspecialchars($row['email']) . '</td>
            <td class="px-6 py-4 text-center">
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold ' . $rol_class . ' uppercase">' . htmlspecialchars($row['rol']) . '</span>
            </td>
            <td class="px-6 py-4 text-text-secondary dark:text-gray-400">' . date('d M Y', strtotime($row['reg_date'])) . '</td>
            <td class="px-6 py-4">
                <span class="inline-flex items-center gap-1.5 py-1 px-2 rounded-full text-xs font-medium text-green-600 bg-green-50 dark:bg-green-900/20 dark:text-green-400">
                    <span class="size-1.5 rounded-full bg-green-600"></span>
                    Activo
                </span>
            </td>
            <td class="px-6 py-4 text-right">
                <div class="flex justify-end gap-1">
                    <button class="p-2 hover:bg-primary/10 text-text-secondary hover:text-primary rounded-lg transition-colors" title="Ver perfil" 
                        onclick="openPreviewModal(' . $jsonData . ')">
                        <span class="material-symbols-outlined text-lg">visibility</span>
                    </button>
                    <button class="p-2 hover:bg-primary/10 text-text-secondary hover:text-primary rounded-lg transition-colors" title="Editar"
                        onclick="openEditModal(' . $jsonData . ')">
                        <span class="material-symbols-outlined text-lg">edit</span>
                    </button>
                    <button class="p-2 hover:bg-red-50 text-text-secondary hover:text-red-500 rounded-lg transition-colors" title="Dar de baja" 
                        onclick="openDeleteModal(' . $row['id'] . ')">
                        <span class="material-symbols-outlined text-lg">person_remove</span>
                    </button>
                </div>
            </td>
        </tr>
        ';
    }
} else {
    echo '<tr><td colspan="7" class="px-6 py-4 text-center text-text-secondary">No se encontraron usuarios.</td></tr>';
}
?>
