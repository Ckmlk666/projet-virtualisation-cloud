@extends('layouts.app')

@section('extra-css')
<style>
  body { margin: 0; overflow: hidden; background-color: #000; }
  
  #solar-system-container {
    width: 100vw;
    height: 100vh; /* Plein écran pour l'immersion */
    position: absolute;
    top: 0;
    left: 0;
    z-index: 0;
  }

  /* L'interface UI par-dessus la 3D */
  .ui-panel {
    position: absolute;
    bottom: 30px;
    right: 30px;
    background: rgba(15, 20, 35, 0.85);
    padding: 20px;
    border-radius: 12px;
    border: 1px solid #4169e1;
    color: white;
    z-index: 10;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(5px);
  }

  .ui-panel h4 { margin-top: 0; color: #ffdd33; }
  
  .control-group { margin-bottom: 15px; }
  .control-group label { display: block; font-size: 12px; margin-bottom: 5px; color: #aaa; }
  .control-group input[type="range"] { width: 100%; cursor: pointer; }

  /* Masquer le layout classique pour cette page immersive */
  main { padding: 0 !important; }
  nav { position: absolute; top: 0; width: 100%; z-index: 10; background: rgba(0,0,0,0.5) !important; }
</style>
@endsection

@section('content')
<div id="solar-system-container"></div>

<div class="ui-panel">
  <h4>CONTRÔLES SIMULATION</h4>
  <div class="control-group">
    <label>VITESSE DE ROTATION</label>
    <input type="range" id="speed-slider" min="0" max="5" step="0.1" value="1">
  </div>
  <div class="control-group">
    <p style="font-size: 11px; color: #888; margin: 0;">Clic gauche: Tourner | Molette: Zoomer</p>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>

<script>
  // --- 1. CONFIGURATION DE BASE ---
  const container = document.getElementById('solar-system-container');
  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(55, window.innerWidth / window.innerHeight, 0.1, 2000);
  camera.position.set(0, 80, 150); // Vue plongeante

  const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: false });
  renderer.setSize(window.innerWidth, window.innerHeight);
  // Amélioration du rendu des couleurs et lumières
  renderer.outputEncoding = THREE.sRGBEncoding; 
  container.appendChild(renderer.domElement);

  const textureLoader = new THREE.TextureLoader();

  // --- 2. FOND ÉTOILÉ (Voie Lactée) ---
  const starsGeometry = new THREE.BufferGeometry();
  const starsCount = 3000;
  const posArray = new Float32Array(starsCount * 3);
  for(let i = 0; i < starsCount * 3; i++) {
      posArray[i] = (Math.random() - 0.5) * 1000; // Dispersion lointaine
  }
  starsGeometry.setAttribute('position', new THREE.BufferAttribute(posArray, 3));
  const starsMaterial = new THREE.PointsMaterial({ size: 0.5, color: 0xffffff, transparent: true, opacity: 0.8 });
  const starMesh = new THREE.Points(starsGeometry, starsMaterial);
  scene.add(starMesh);

  // --- 3. LUMIÈRES ---
  scene.add(new THREE.AmbientLight(0x222222)); // Évite le noir complet
  const sunLight = new THREE.PointLight(0xffffff, 2.5, 600);
  scene.add(sunLight);

  // --- 4. LE SOLEIL ---
  const sunGeo = new THREE.SphereGeometry(15, 64, 64);
  // MeshBasicMaterial pour qu'il ne soit pas affecté par sa propre ombre
  const sunMat = new THREE.MeshBasicMaterial({ 
      map: textureLoader.load('/images/textures/sun.jpg'),
      color: 0xffffee // Légère teinte chaude
  });
  const sun = new THREE.Mesh(sunGeo, sunMat);
  scene.add(sun);

  // --- 5. LES PLANÈTES ---
  const planetsData = [
    { name: 'Mercure', size: 1.2, dist: 25, speed: 0.04, map: 'mercury.jpg' },
    { name: 'Venus', size: 2.2, dist: 35, speed: 0.015, map: 'venus.jpg' },
    { name: 'Terre', size: 2.4, dist: 48, speed: 0.01, map: 'earth.jpg', hasMoon: true },
    { name: 'Mars', size: 1.6, dist: 62, speed: 0.008, map: 'mars.jpg' },
    { name: 'Jupiter', size: 6.5, dist: 90, speed: 0.002, map: 'jupiter.jpg' },
    { name: 'Saturne', size: 5.5, dist: 130, speed: 0.0009, map: 'saturn.jpg', hasRings: true }
  ];

  const planetObjects = [];
  let globalSpeedMultiplier = 1;

  planetsData.forEach(data => {
    // Le pivot au centre du soleil pour faire tourner la planète
    const pivot = new THREE.Object3D();
    scene.add(pivot);

    // La planète
    const geo = new THREE.SphereGeometry(data.size, 64, 64);
    const mat = new THREE.MeshStandardMaterial({ 
        map: textureLoader.load('/images/textures/' + data.map),
        roughness: 0.8 
    });
    const mesh = new THREE.Mesh(geo, mat);
    mesh.position.x = data.dist;
    pivot.add(mesh);

    // Trait d'orbite
    const orbitGeo = new THREE.RingGeometry(data.dist - 0.1, data.dist + 0.1, 128);
    const orbitMat = new THREE.MeshBasicMaterial({ color: 0xffffff, transparent: true, opacity: 0.15, side: THREE.DoubleSide });
    const orbit = new THREE.Mesh(orbitGeo, orbitMat);
    orbit.rotation.x = Math.PI / 2;
    scene.add(orbit);

    // Ajout d'une Lune pour la Terre
    if(data.hasMoon) {
        const moonGeo = new THREE.SphereGeometry(0.5, 32, 32);
        const moonMat = new THREE.MeshStandardMaterial({ map: textureLoader.load('/images/textures/moon.jpg') });
        const moon = new THREE.Mesh(moonGeo, moonMat);
        moon.position.x = data.size + 1.5; // Distance de la lune
        
        const moonPivot = new THREE.Object3D();
        moonPivot.add(moon);
        mesh.add(moonPivot); // La lune tourne autour de la Terre
        data.moonPivot = moonPivot;
    }

    // Ajout des anneaux pour Saturne
    if(data.hasRings) {
        const ringGeo = new THREE.RingGeometry(data.size + 1.5, data.size + 5, 64);
        // On utilise la texture de saturne étirée, ou une couleur unie avec opacité
        const ringMat = new THREE.MeshStandardMaterial({ 
            color: 0xd2b48c, transparent: true, opacity: 0.7, side: THREE.DoubleSide 
        });
        const ring = new THREE.Mesh(ringGeo, ringMat);
        ring.rotation.x = Math.PI / 2 - 0.2; // Inclinaison des anneaux
        mesh.add(ring);
    }

    planetObjects.push({ pivot, mesh, speed: data.speed, moonPivot: data.moonPivot });
  });

  // --- 6. GESTION DE L'INTERFACE UI ---
  document.getElementById('speed-slider').addEventListener('input', (e) => {
      globalSpeedMultiplier = parseFloat(e.target.value);
  });

  // --- 7. CONTRÔLES CAMÉRA ---
  const controls = new THREE.OrbitControls(camera, renderer.domElement);
  controls.enableDamping = true;
  controls.dampingFactor = 0.05;
  controls.maxDistance = 500; // Limite le dézoom

  // --- 8. ANIMATION ---
  function animate() {
    requestAnimationFrame(animate);

    sun.rotation.y += 0.002 * globalSpeedMultiplier;
    starMesh.rotation.y += 0.0002 * globalSpeedMultiplier; // Les étoiles tournent très lentement

    planetObjects.forEach(p => {
      p.pivot.rotation.y += p.speed * globalSpeedMultiplier; // Révolution autour du Soleil
      p.mesh.rotation.y += 0.02 * globalSpeedMultiplier;     // Rotation sur elle-même
      
      if(p.moonPivot) {
          p.moonPivot.rotation.y += 0.05 * globalSpeedMultiplier; // La lune tourne vite !
      }
    });

    controls.update();
    renderer.render(scene, camera);
  }

  // Redimensionnement de la fenêtre
  window.addEventListener('resize', () => {
      camera.aspect = window.innerWidth / window.innerHeight;
      camera.updateProjectionMatrix();
      renderer.setSize(window.innerWidth, window.innerHeight);
  });

  animate();
</script>
@endsection
