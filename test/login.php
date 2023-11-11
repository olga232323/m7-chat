<!-- M07 - Ejemplo index.php - Olga Clemente Molina -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="../chat_index.php" method="POST">
      <label for="username">Username: </label>
        <input type="text" name="username" id="username" size="25" placeholder="Introduce tu usuario" value="<?php if(isset($_GET['username'])){echo $_GET['username'];} ?>">
      <input type="submit" name="inicio" value="Enviar">
    </form>
    
</body>
</html>