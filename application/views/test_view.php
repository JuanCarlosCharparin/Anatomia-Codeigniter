<!DOCTYPE html>
<html>
<head>
    <title>Prueba de Consulta</title>
</head>
<body>
    <h1>Usuarios:</h1>
    <ul>
        <?php foreach ($usuarios as $usuario): ?>
            <li><?php echo $usuario->nombre; ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>