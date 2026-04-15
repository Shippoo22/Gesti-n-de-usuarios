<!DOCTYPE html>
<html>
<head>
    <title>Crear cuenta</title>
    <style>
        body {
            background: #0d1117;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: white;
            margin: 0;
            font-family: sans-serif;
        }
        .login-box {
            background: rgba(255,255,255,0.1);
            padding: 30px;
            border-radius: 10px;
            backdrop-filter: blur(8px);
            width: 350px;
            text-align: center;
        }
        .login-box input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            background-color: #ffffffd0;
        }
        .login-box button {
            width: 100%;
            padding: 10px;
            background-color: #238636;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .login-box a {
            display: block;
            margin-top: 15px;
            color: #58a6ff;
            text-decoration: none;
        }
        .login-box a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Crear cuenta</h2>
    <form action="procesar_registro.php" method="POST">
        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Registrarme</button>
    </form>
    <a href="login.php">Ya tengo cuenta</a>
</div>

</body>
</html>