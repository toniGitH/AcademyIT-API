<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba Técnica</title>
    <style>
        /* Resetear márgenes y rellenos para asegurar consistencia */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Fondo degradado */
        body {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #4facfe, #00f2fe); /* Degradado de color */
            color: white;
            text-align: center;
            padding: 20px;
        }

        h1 {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 10px;
            white-space: nowrap; /* Evita que el texto se divida */
            overflow-wrap: break-word; /* Asegura que el texto largo se ajuste */
            word-wrap: break-word;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 2rem;
            margin-bottom: 15px;
            font-weight: 500;
            white-space: nowrap; /* Evita que el texto se divida */
            overflow-wrap: break-word; /* Asegura que el texto largo se ajuste */
            word-wrap: break-word;
            margin-bottom: 40px;
        }

        h3 {
            font-size: 1.5rem;
            font-weight: 400;
            margin-top: 0;
            white-space: nowrap; /* Evita que el texto se divida */
            overflow-wrap: break-word; /* Asegura que el texto largo se ajuste */
            word-wrap: break-word;
            margin-bottom: 20px;
            color: rgba(168, 168, 168, 0.7);
        }

        /* Sombra en los textos para mejorar la visibilidad */
        h1, h2, h3 {
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.4);
        }

        /* Estilo para hacer el cuerpo de la página más atractivo */
        .content {
            padding: 20px;
            border-radius: 10px;
            background-color: rgba(0, 0, 0, 0.6); /* Fondo ligeramente oscuro para resaltar texto */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            max-width: 80%; /* Limita el ancho máximo para evitar que el texto se salga */
            width: 100%;
            text-align: center; /* Centrado horizontal de todo el contenido */
            padding-left: 20px; /* Relleno extra a la izquierda */
            padding-right: 20px; /* Relleno extra a la derecha */
        }

    </style>
</head>
<body>
    <div class="content">
        <h1>API REST</h1>
        <h2>Gestión de alumnos, asignaturas y notas</h2>
        <h3>Prueba técnica de PHP para la IT Academy</h3>
    </div>
</body>
</html>
