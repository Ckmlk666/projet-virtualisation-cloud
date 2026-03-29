<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Documentaire Spatial</title>
  <style>
    body {
      margin: 0; padding: 0;
      background: radial-gradient(circle at center, #000010 50%, #000015 100%);
      color: white; font-family: 'Arial', sans-serif;
      min-height: 100vh; overflow-x: hidden;
    }
    /* Navbar fixe en haut */
    nav {
      position: fixed; top: 0; width: 100%;
      background: rgba(0, 0, 20, 0.9);
      padding: 15px 0; text-align: center;
      box-shadow: 0 2px 10px rgba(0,0,0,0.5);
      z-index: 1000;
    }
    nav a {
      color: #ffdd33; text-decoration: none;
      margin: 0 20px; font-weight: bold; font-size: 18px;
      transition: 0.3s;
    }
    nav a:hover { color: #fff; text-shadow: 0 0 10px #ffdd33; }
    
    /* Conteneur principal sous la navbar */
    .content-area {
      margin-top: 80px; /* Laisse la place à la navbar */
      padding: 20px;
      display: flex; flex-direction: column; align-items: center;
    }
  </style>
  @yield('extra-css')
</head>
<body>

  <nav>
    <a href="/">🌍 La Terre</a>
    <a href="/systeme-solaire">🌞 Système Solaire</a>
    <a href="/galaxie">🌌 Notre Galaxie</a>
    <a href="/quiz">🧠 Quiz (10 Q)</a>
  </nav>

  <div class="content-area">
    @yield('content')
  </div>

</body>
</html>
