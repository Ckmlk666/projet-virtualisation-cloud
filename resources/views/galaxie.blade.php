@extends('layouts.app')

@section('content')
<style>
  #galaxy-container {
    width: 80vw;
    height: 700px; /* Hauteur fixe pour empêcher la boîte de disparaître */
    background-color: #000000; /* Fond noir absolu */
    border-radius: 10px;
    box-shadow: 0 0 30px rgba(65, 105, 225, 0.4);
    margin-top: 20px;
    position: relative;
    overflow: hidden;
    cursor: grab;
  }
  #galaxy-container:active {
    cursor: grabbing;
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

<div class="container-fluid">
  <h2 style="text-align: center; color: #4169e1; text-shadow: 0 0 10px #4169e1; margin-top: 10px;">
    🌀 Notre Galaxie
  </h2>
  
  <div id="galaxy-container"></div>
</div>
<div class="description-panel">
    <h3>🌌 La Voie Lactée</h3>
    <p>Notre galaxie, la Voie Lactée, est une galaxie spirale géante contenant entre 100 et 400 milliards d'étoiles. Elle se caractérise par un bulbe central très dense et lumineux (composé d'étoiles plus anciennes), entouré de vastes bras spiraux où de nouvelles étoiles se forment en permanence.</p>
    <p>Notre système solaire ne se trouve pas au centre, mais dans l'un de ces bras (le bras d'Orion), à environ 27 000 années-lumière du trou noir supermassif qui réside au cœur de notre galaxie.</p>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
  // --- 1. CONFIGURATION ---
  const container = document.getElementById('galaxy-container');
  const scene = new THREE.Scene();
  
  // Caméra reculée (Z=180) pour voir la galaxie en entier
  const camera = new THREE.PerspectiveCamera(60, container.clientWidth / container.clientHeight, 0.1, 2000);
  camera.position.set(0, 80, 180);

  const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: false });
  renderer.setSize(container.clientWidth, container.clientHeight);
  container.appendChild(renderer.domElement);

  // --- 2. TEXTURE GÉNÉRÉE ---
  function createStar() {
    const canvas = document.createElement('canvas');
    canvas.width = 32;
    canvas.height = 32;
    const ctx = canvas.getContext('2d');
    const gradient = ctx.createRadialGradient(16, 16, 0, 16, 16, 16);
    gradient.addColorStop(0, 'rgba(255, 255, 255, 1)');
    gradient.addColorStop(0.2, 'rgba(255, 255, 255, 0.8)');
    gradient.addColorStop(0.5, 'rgba(150, 200, 255, 0.2)');
    gradient.addColorStop(1, 'rgba(0, 0, 0, 0)');
    ctx.fillStyle = gradient;
    ctx.fillRect(0, 0, 32, 32);
    return new THREE.CanvasTexture(canvas);
  }
  const starTexture = createStar();

  // --- 3. MATHÉMATIQUES GALAXIE ---
  const count = 60000; 
  const radius = 120;
  const geometry = new THREE.BufferGeometry();
  const positions = new Float32Array(count * 3);
  const colors = new Float32Array(count * 3);

  const colorCenter = new THREE.Color('#ffddaa'); // Cœur doré
  const colorEdge = new THREE.Color('#4169e1');   // Bras bleus

  for(let i = 0; i < count; i++) {
    const i3 = i * 3;
    const r = Math.random() * radius;
    const spinAngle = r * 4.0; 
    const branchAngle = ((i % 2) / 2) * Math.PI * 2; // 2 Bras

    // Dispersion
    const randomX = Math.pow(Math.random(), 3) * (Math.random() < 0.5 ? 1 : -1) * 0.3 * radius;
    const randomY = Math.pow(Math.random(), 3) * (Math.random() < 0.5 ? 1 : -1) * 0.3 * radius;
    const randomZ = Math.pow(Math.random(), 3) * (Math.random() < 0.5 ? 1 : -1) * 0.3 * radius;

    positions[i3    ] = Math.cos(branchAngle + spinAngle) * r + randomX;
    positions[i3 + 1] = randomY; 
    positions[i3 + 2] = Math.sin(branchAngle + spinAngle) * r + randomZ;

    // Mélange des couleurs
    const mix = colorCenter.clone();
    mix.lerp(colorEdge, r / radius);
    
    colors[i3    ] = mix.r;
    colors[i3 + 1] = mix.g;
    colors[i3 + 2] = mix.b;
  }

  geometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
  geometry.setAttribute('color', new THREE.BufferAttribute(colors, 3));

  const material = new THREE.PointsMaterial({
    size: 1.5,
    map: starTexture,
    transparent: true,
    alphaTest: 0.01,
    depthWrite: false,
    blending: THREE.AdditiveBlending,
    vertexColors: true
  });

  const galaxy = new THREE.Points(geometry, material);
  scene.add(galaxy);

  // --- 4. CONTRÔLES ---
  const controls = new THREE.OrbitControls(camera, renderer.domElement);
  controls.enableDamping = true;
  controls.dampingFactor = 0.05;

  // --- 5. ANIMATION CONSTANTE ---
  function animate() {
    requestAnimationFrame(animate);
    galaxy.rotation.y -= 0.001; // Vitesse douce et fixe
    controls.update();
    renderer.render(scene, camera);
  }

  // --- 6. REDIMENSIONNEMENT ---
  window.addEventListener('resize', () => {
    camera.aspect = container.clientWidth / container.clientHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(container.clientWidth, container.clientHeight);
  });

  animate();
});
</script>
@endsection
