@extends('layouts.app')

@section('extra-css')
<style>
  /* Conteneur 3D simple et robuste */
  #solar-system-container {
    width: 80vw;
    height: 90vh; /* Prend 80% de la hauteur de l'écran */
    margin-top: 20px;
    border-radius: 15px;
    overflow: hidden;
    background: #050505; /* Fond spatial très sombre */
    box-shadow: 0 0 50px rgba(255, 165, 0, 0.2);
    position: relative;
    cursor: grab;
  }
  #solar-system-container:active {
    cursor: grabbing;
  }
  .page-title {
    text-align: center; 
    color: #ffa500; 
    text-shadow: 0 0 10px #ffa500;
    margin-bottom: 0;
  }
  .description-panel {
    background-color: rgba(15, 20, 35, 0.9);
    border-left: 5px solid #4169e1;
    padding: 25px;
    margin: 30px auto 50px auto; /* Marge en bas pour respirer */
    max-width: 900px;
    border-radius: 8px;
    color: #e0e0e0;
    font-size: 1.2em;
    line-height: 1.6;
    box-shadow: 0 4px 15px rgba(0,0,0,0.5);
  }
  .description-panel h3 { color: #ffa500; margin-top: 0; font-size: 1.5em; }
  .page-subtitle {
    text-align: center;
    color: #aaa;
    font-size: 14px;
    margin-bottom: 20px;
  }
</style>
@endsection

@section('content')
<div class="container-fluid">
  <h2 class="page-title">☀️ Le Système Solaire en Mouvement</h2>
  
  <div id="solar-system-container"></div>
</div>
<div class="description-panel">
    <h3>☀️ Le Système Solaire</h3>
    <p>Notre système solaire est un ballet cosmique dominé par une étoile centrale, le Soleil, qui représente à lui seul 99,8% de la masse totale du système. Autour de lui gravitent huit planètes principales, divisées en deux catégories :</p>
    <ul>
        <li><strong>Les planètes telluriques (rocheuses) :</strong> Mercure, Vénus, la Terre et Mars. Elles sont petites et proches du Soleil.</li>
        <li><strong>Les géantes gazeuses et glacées :</strong> Jupiter, Saturne, Uranus et Neptune. Elles sont massives, lointaines, et composées principalement de gaz et de glaces.</li>
    </ul>
    <p>La force de gravité générée par le Soleil maintient l'ensemble de ces corps célestes, ainsi que des millions d'astéroïdes et de comètes, dans leur orbite perpétuelle.</p>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>

<script>
    // 1. Initialisation basique
    const container = document.getElementById('solar-system-container');
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(60, container.clientWidth / container.clientHeight, 0.1, 1000);
    camera.position.set(0, 60, 120);

    const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
    renderer.setSize(container.clientWidth, container.clientHeight);
    container.appendChild(renderer.domElement);

    const controls = new THREE.OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;

    // Lumière
    const ambientLight = new THREE.AmbientLight(0x404040, 2); 
    scene.add(ambientLight);
    const pointLight = new THREE.PointLight(0xffffff, 3, 300);
    scene.add(pointLight);

    // 2. Le Soleil
    const sunGeometry = new THREE.SphereGeometry(8, 32, 32);
    const sunMaterial = new THREE.MeshBasicMaterial({ color: 0xffcc00 });
    const sun = new THREE.Mesh(sunGeometry, sunMaterial);
    scene.add(sun);

    // =========================================================
    // 🌟 NOUVEAU : FONCTION POUR CRÉER LE TEXTE DES PLANÈTES
    // =========================================================
    function createPlanetLabel(name) {
        const canvas = document.createElement('canvas');
        canvas.width = 256;
        canvas.height = 128;
        const context = canvas.getContext('2d');

        // Style du texte
        context.font = "bold 28px Arial";
        context.textAlign = "center";
        context.textBaseline = "middle";

        // Contour noir pour être lisible sur fond sombre ou clair
        context.strokeStyle = "rgba(0, 0, 0, 0.8)";
        context.lineWidth = 5;
        context.strokeText(name, canvas.width / 2, canvas.height / 2);

        // Remplissage blanc
        context.fillStyle = "#ffffff";
        context.fillText(name, canvas.width / 2, canvas.height / 2);

        // Création du Sprite Three.js
        const texture = new THREE.CanvasTexture(canvas);
        const spriteMaterial = new THREE.SpriteMaterial({ map: texture, transparent: true });
        const sprite = new THREE.Sprite(spriteMaterial);
        
        // Taille de l'étiquette
        sprite.scale.set(16, 8, 1); 
        return sprite;
    }
    // =========================================================

    // 3. Les Planètes
    const planets = [];
    const planetData = [
        { name: 'Mercure', size: 0.8, color: 0xaaaaaa, distance: 15, speed: 0.04 },
        { name: 'Vénus', size: 1.5, color: 0xffaa00, distance: 22, speed: 0.015 },
        { name: 'Terre', size: 1.6, color: 0x2233ff, distance: 30, speed: 0.01 },
        { name: 'Mars', size: 1.2, color: 0xff3300, distance: 38, speed: 0.008 },
        { name: 'Jupiter', size: 4.5, color: 0xff9900, distance: 55, speed: 0.002 },
        { name: 'Saturne', size: 3.5, color: 0xeedd88, distance: 75, speed: 0.0009 },
        { name: 'Uranus', size: 2.5, color: 0x00ccff, distance: 95, speed: 0.0004 },
        { name: 'Neptune', size: 2.4, color: 0x3333ff, distance: 110, speed: 0.0001 }
    ];

    planetData.forEach(data => {
        // Pivot pour la rotation autour du soleil
        const pivot = new THREE.Object3D();
        scene.add(pivot);

        // La Planète
        const geo = new THREE.SphereGeometry(data.size, 32, 32);
        const mat = new THREE.MeshLambertMaterial({ color: data.color });
        const mesh = new THREE.Mesh(geo, mat);
        mesh.position.x = data.distance;

        // 🌟 AJOUT DE L'ÉTIQUETTE À LA PLANÈTE
        const label = createPlanetLabel(data.name);
        // On place l'étiquette juste en dessous de la planète (axe Y)
        label.position.set(0, -data.size - 2.5, 0); 
        mesh.add(label); // L'étiquette est attachée à la planète !

        // Anneau de trajectoire
        const pathGeo = new THREE.RingGeometry(data.distance - 0.1, data.distance + 0.1, 64);
        const pathMat = new THREE.MeshBasicMaterial({ color: 0xffffff, side: THREE.DoubleSide, transparent: true, opacity: 0.2 });
        const path = new THREE.Mesh(pathGeo, pathMat);
        path.rotation.x = Math.PI / 2;
        scene.add(path);

        // Anneaux de Saturne (Bonus visuel)
        if (data.name === 'Saturne') {
            const ringGeo = new THREE.RingGeometry(data.size + 1, data.size + 3, 32);
            const ringMat = new THREE.MeshBasicMaterial({ color: 0xeedd88, side: THREE.DoubleSide, transparent: true, opacity: 0.7 });
            const ring = new THREE.Mesh(ringGeo, ringMat);
            ring.rotation.x = Math.PI / 2.2;
            mesh.add(ring);
        }

        pivot.add(mesh);
        planets.push({ pivot: pivot, mesh: mesh, speed: data.speed });
    });

    // 4. Animation
    function animate() {
        requestAnimationFrame(animate);

        // Fait tourner les planètes autour du Soleil
        planets.forEach(p => {
            p.pivot.rotation.y += p.speed;
            p.mesh.rotation.y += 0.02; // Rotation sur elles-mêmes
        });

        controls.update();
        renderer.render(scene, camera);
    }
    animate();

    // Redimensionnement de la fenêtre
    window.addEventListener('resize', () => {
        camera.aspect = container.clientWidth / container.clientHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(container.clientWidth, container.clientHeight);
    });
</script>
@endsection
