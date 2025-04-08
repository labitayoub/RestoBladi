<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur 404 - Page Introuvable</title>
    <style>
*{
    transition: all 0.6s;
}

html {
    height: 100%;
}

body{
    font-family: 'Lato', sans-serif;
    color: #888;
    margin: 0;
}

#main{
    display: table;
    width: 100%;
    height: 100vh;
    text-align: center;
}

.fof{
    display: table-cell;
    vertical-align: middle;
}

.fof h1{
    font-size: 90px;
    display: inline-block;
    padding-right: 12px;
    animation: type .5s alternate infinite;
}

@keyframes type{
    from{box-shadow: inset -3px 0px 0px #888;}
    to{box-shadow: inset -3px 0px 0px transparent;}
}

.buttons {
    margin-top: 20px;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    margin: 0 10px;
    background-color: #888;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
    transition: background-color 0.3s;
}

.btn:hover {
    background-color: #666;
}
    </style>
</head>
<body>
    <div id="main">
        <div class="fof">
              <h1>Error 404</h1>
              <p>Erreur ! L'adresse que tu as entrée est incorrecte.</p>
              <div class="buttons">
                  <a href="#" id="backButton" class="btn">⬅️ Retour en arrière</a>
                  <a href="{{ url('/') }}" class="btn">🏠 Page d'accueil</a>
              </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const backButton = document.getElementById('backButton');
            
            backButton.addEventListener('click', function(event) {
                event.preventDefault();
                
                // Vérifie si l'historique de navigation existe
                if (window.history && window.history.length > 1) {
                    window.history.back();
                } else {
                    // Si pas d'historique, redirige vers la page d'accueil
                    window.location.href = '{{ url("/") }}';
                }
            });
        });
    </script>
</body>
</html>
