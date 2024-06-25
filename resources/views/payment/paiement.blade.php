<!-- resources/views/payment/confirmation.blade.php -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de Paiement</title>
    <style>
        body {
            /* display: flex; */
            /* justify-content: center; */
            font-family: Arial, sans-serif;
            text-align: center;
            color: white;
            padding: 50px;
            background-color: #171616;
        }
        .progress-bar {
            margin: 20px 0;
            height: 30px;
            width: 100%;
            background-color: #fffcfc;
            border-radius: 5px;
            overflow: hidden;
        }
        .progress-bar-inner {
            height: 100%;
            width: 0;
            background-color: #fb4141;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Confirmation de Paiement</h1>
    <p>Votre paiement a été traité avec succès.</p>
    <p>Vous pouvez maintenant retourner à l'application.</p>

    <div class="progress-bar">
        <div class="progress-bar-inner" id="progressBar"></div>
    </div>

    <script>
        // Simuler un processus de chargement
        function move() {
            var elem = document.getElementById("progressBar");
            var width = 0;
            var id = setInterval(frame, 100);
            function frame() {
                if (width >= 100) {
                    clearInterval(id);
                } else {
                    width++;
                    elem.style.width = width + '%';
                }
            }
        }

        move();
    </script>
</body>
</html>
