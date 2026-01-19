<!DOCTYPE html>
<html lang="es">
<body>
    <h2>Enviar pedido por WhatsApp</h2>
    <form action="procesar.php" method="POST">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" required><br><br>
        
        <label>Producto:</label><br>
        <input type="text" name="producto" required><br><br>
        
        <label>Mensaje adicional:</label><br>
        <textarea name="mensaje"></textarea><br><br>
        
        <button type="submit" name="enviar">Enviar a WhatsApp</button>
    </form>
</body>
</html>