@extends('layouts.app')

@section('extra-css')
<style>
  #earth-container {
    width: 80vw;
    height: 90vh;
    margin-top: 20px;
    border-radius: 15px;
    overflow: hidden;
    background: #000;
    box-shadow: 0 0 50px rgba(65, 105, 225, 0.4);
    position: relative;
    cursor: grab;
  }
  .info-panel {
    background: rgba(10, 15, 30, 0.9);
    padding: 25px;
    border-radius: 10px;
    margin: 30px auto;
    border: 1px solid #4169e1;
    color: white;
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
</style>
@endsection

@section('content')
<div class="container">
  <h1 style="text-align:center; color: #4169e1;">🌍 La Terre en 3D Interactive</h1>
  
  <div id="earth-container"></div>

  <div class="info-panel">
    <h3 style="color:#ffdd33;">Données Astrophysiques</h3>
    <p><strong>Description :</strong> {{ $terre ? $terre->description : 'N/A' }}</p>
    <p><strong>Distance :</strong> {{ $terre ? $terre->distance : 'N/A' }}</p>
  </div>
</div>
<div class="description-panel">
    <h3>🌍 Notre Planète Bleue</h3>
    <p>La Terre est la troisième planète du système solaire et, à ce jour, le seul endroit connu dans l'Univers abritant la vie. Elle tourne sur elle-même en 24 heures (ce qui crée l'alternance du jour et de la nuit) et effectue une orbite complète autour du Soleil en environ 365,25 jours.</p>
    <p>Surnommée la "Planète Bleue" en raison de l'abondance d'eau liquide qui recouvre 71% de sa surface, la Terre possède également une atmosphère protectrice riche en oxygène et en azote, qui nous protège des radiations solaires mortelles et des météorites.</p>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>
<script>
  const container = document.getElementById('earth-container');
  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(45, container.clientWidth / container.clientHeight, 0.1, 1000);
  camera.position.z = 3.5;

  const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
  renderer.setSize(container.clientWidth, container.clientHeight);
  container.appendChild(renderer.domElement);

  // Notre fameuse Terre en fil de fer bleu pour tester !
  const geometry = new THREE.SphereGeometry(1, 64, 64);
  // Chargement de l'image locale
  const textureLoader = new THREE.TextureLoader();
  const earthTexture = textureLoader.load('/images/textures/earth.jpg');

  // Matériau réaliste
  const material = new THREE.MeshStandardMaterial({ 
      map: earthTexture,
      roughness: 0.8,
      metalness: 0.2
  });
  
  const earth = new THREE.Mesh(geometry, material);
  scene.add(earth);

  // Lumières (Ambiante + Soleil) pour voir la texture
  const ambientLight = new THREE.AmbientLight(0x404040, 1.5); 
  scene.add(ambientLight);

  const sunLight = new THREE.DirectionalLight(0xffffff, 2); 
  sunLight.position.set(5, 3, 5); 
  scene.add(sunLight);

  const controls = new THREE.OrbitControls(camera, renderer.domElement);
  controls.enableDamping = true;

  function animate() {
    requestAnimationFrame(animate);
    earth.rotation.y += 0.002; 
    controls.update();
    renderer.render(scene, camera);
  }

  window.addEventListener('resize', () => {
      camera.aspect = container.clientWidth / container.clientHeight;
      camera.updateProjectionMatrix();
      renderer.setSize(container.clientWidth, container.clientHeight);
  });

  animate();
</script>
@endsection
