@extends('layouts.app')

@section('extra-css')
<style>
  body { 
    background-color: #050505; 
    color: #eee; 
  }
  .quiz-container {
    max-width: 850px; 
    margin: 40px auto; 
    background: rgba(15, 20, 35, 0.9);
    padding: 30px; 
    border-radius: 12px; 
    border: 1px solid #4169e1;
    box-shadow: 0 0 20px rgba(65, 105, 225, 0.3);
  }
  
  /* --- NOUVEAU DESIGN DES QUESTIONS --- */
  .question-block { 
    margin-bottom: 25px; 
    padding: 20px; 
    border: 1px solid #4169e1; /* La fameuse bordure bleue */
    border-radius: 10px; 
    background: rgba(10, 15, 30, 0.6); /* Fond légèrement plus sombre pour le contraste */
    box-shadow: inset 0 0 10px rgba(65, 105, 225, 0.1);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }
  .question-block:hover {
    box-shadow: 0 0 15px rgba(65, 105, 225, 0.4);
    transform: translateY(-2px);
  }

  .question-block h4 { 
    color: #ffdd33; 
    margin-top: 0;
    margin-bottom: 20px; 
    font-size: 1.3em;
  }
  .options label { 
    display: block; 
    margin-bottom: 12px; 
    cursor: pointer; 
    font-size: 1.1em; 
    padding: 8px 15px;
    border-radius: 5px;
    transition: background 0.2s;
  }
  .options label:hover {
    background: rgba(65, 105, 225, 0.2);
  }
  .options input { 
    margin-right: 15px; 
    transform: scale(1.2);
  }

  /* Bouton et Résultat */
  .submit-btn {
    background: linear-gradient(45deg, #4169e1, #2a4baf); 
    color: white; 
    border: none; 
    padding: 15px 30px;
    font-size: 1.2em; 
    border-radius: 8px; 
    cursor: pointer; 
    width: 100%;
    margin-top: 20px;
    text-transform: uppercase;
    font-weight: bold;
    letter-spacing: 1px;
    box-shadow: 0 5px 15px rgba(65, 105, 225, 0.4);
  }
  .submit-btn:hover { 
    background: linear-gradient(45deg, #2a4baf, #1e3680); 
  }
  #result-box {
    display: none; 
    margin-top: 30px; 
    padding: 20px; 
    border-radius: 8px;
    text-align: center; 
    font-size: 1.5em; 
    font-weight: bold;
  }
  .score-good { background-color: rgba(40, 167, 69, 0.2); border: 2px solid #28a745; color: #28a745; text-shadow: 0 0 5px rgba(40, 167, 69, 0.5); }
  .score-bad { background-color: rgba(220, 53, 69, 0.2); border: 2px solid #dc3545; color: #dc3545; text-shadow: 0 0 5px rgba(220, 53, 69, 0.5); }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <h2 style="text-align: center; color: #ffa500; text-shadow: 0 0 15px rgba(255,165,0,0.5); margin-bottom: 5px;">🧠 Évaluation Spatiale</h2>
    <p style="text-align: center; color: #aaa; margin-bottom: 30px;">
        Astronaute identifié : <strong style="color: #fff;">{{ Auth::user()->name }}</strong>
    </p>

    <div class="quiz-container">
        <form id="space-quiz">
            @csrf
            
            <div class="question-block">
                <h4>1. Quelle est la planète la plus proche du Soleil ?</h4>
                <div class="options">
                    <label><input type="radio" name="q1" value="0"> Vénus</label>
                    <label><input type="radio" name="q1" value="1"> Mercure</label>
                    <label><input type="radio" name="q1" value="0"> La Terre</label>
                    <label><input type="radio" name="q1" value="0"> Mars</label>
                </div>
            </div>

            <div class="question-block">
                <h4>2. Quelle est la planète la plus massive de notre Système Solaire ?</h4>
                <div class="options">
                    <label><input type="radio" name="q2" value="0"> Saturne</label>
                    <label><input type="radio" name="q2" value="0"> Uranus</label>
                    <label><input type="radio" name="q2" value="1"> Jupiter</label>
                    <label><input type="radio" name="q2" value="0"> Neptune</label>
                </div>
            </div>

            <div class="question-block">
                <h4>3. Comment s'appelle la galaxie dans laquelle nous nous trouvons ?</h4>
                <div class="options">
                    <label><input type="radio" name="q3" value="0"> La Galaxie d'Andromède</label>
                    <label><input type="radio" name="q3" value="0"> La Galaxie du Sombrero</label>
                    <label><input type="radio" name="q3" value="0"> Le Grand Nuage de Magellan</label>
                    <label><input type="radio" name="q3" value="1"> La Voie Lactée</label>
                </div>
            </div>

            <div class="question-block">
                <h4>4. Quelle planète est souvent surnommée la "Planète Rouge" ?</h4>
                <div class="options">
                    <label><input type="radio" name="q4" value="0"> Jupiter</label>
                    <label><input type="radio" name="q4" value="1"> Mars</label>
                    <label><input type="radio" name="q4" value="0"> Vénus</label>
                    <label><input type="radio" name="q4" value="0"> Mercure</label>
                </div>
            </div>

            <div class="question-block">
                <h4>5. Combien de temps faut-il à la Terre pour faire une orbite complète autour du Soleil ?</h4>
                <div class="options">
                    <label><input type="radio" name="q5" value="0"> Environ 24 heures</label>
                    <label><input type="radio" name="q5" value="0"> Environ 28 jours</label>
                    <label><input type="radio" name="q5" value="1"> Environ 365,25 jours</label>
                    <label><input type="radio" name="q5" value="0"> Environ 12 ans</label>
                </div>
            </div>

            <div class="question-block">
                <h4>6. Quelle planète est célèbre pour ses anneaux spectaculaires très visibles ?</h4>
                <div class="options">
                    <label><input type="radio" name="q6" value="1"> Saturne</label>
                    <label><input type="radio" name="q6" value="0"> Uranus</label>
                    <label><input type="radio" name="q6" value="0"> Neptune</label>
                    <label><input type="radio" name="q6" value="0"> Jupiter</label>
                </div>
            </div>

            <div class="question-block">
                <h4>7. Qui fut le tout premier être humain à voyager dans l'espace ?</h4>
                <div class="options">
                    <label><input type="radio" name="q7" value="0"> Neil Armstrong</label>
                    <label><input type="radio" name="q7" value="0"> Buzz Aldrin</label>
                    <label><input type="radio" name="q7" value="1"> Youri Gagarine</label>
                    <label><input type="radio" name="q7" value="0"> Thomas Pesquet</label>
                </div>
            </div>

            <div class="question-block">
                <h4>8. Quelle est l'étoile la plus proche de la planète Terre ?</h4>
                <div class="options">
                    <label><input type="radio" name="q8" value="0"> Proxima du Centaure</label>
                    <label><input type="radio" name="q8" value="0"> Sirius</label>
                    <label><input type="radio" name="q8" value="0"> L'Étoile Polaire</label>
                    <label><input type="radio" name="q8" value="1"> Le Soleil</label>
                </div>
            </div>

            <div class="question-block">
                <h4>9. Comment se nomme le seul satellite naturel de la Terre ?</h4>
                <div class="options">
                    <label><input type="radio" name="q9" value="0"> Titan</label>
                    <label><input type="radio" name="q9" value="0"> Europe</label>
                    <label><input type="radio" name="q9" value="1"> La Lune</label>
                    <label><input type="radio" name="q9" value="0"> Io</label>
                </div>
            </div>

            <div class="question-block">
                <h4>10. Qu'est-ce qu'un trou noir en astrophysique ?</h4>
                <div class="options">
                    <label><input type="radio" name="q10" value="0"> Une étoile filante qui s'est éteinte</label>
                    <label><input type="radio" name="q10" value="0"> Un nuage de gaz très dense</label>
                    <label><input type="radio" name="q10" value="1"> Une région de l'espace où la gravité empêche toute matière et lumière de s'échapper</label>
                    <label><input type="radio" name="q10" value="0"> Une exoplanète inhabitable</label>
                </div>
            </div>

            <button type="submit" class="submit-btn" id="btn-submit">Soumettre mon rapport de mission</button>
        </form>

        <div id="result-box"></div>
    </div>
</div>

<script>
document.getElementById('space-quiz').addEventListener('submit', function(event) {
    event.preventDefault(); 
    
    let btn = document.getElementById('btn-submit');
    btn.innerText = "Transmission des données à la base...";
    btn.disabled = true;

    let totalQuestions = 10;
    let score = 0;

    for (let i = 1; i <= totalQuestions; i++) {
        let radios = document.getElementsByName('q' + i);
        for (let j = 0; j < radios.length; j++) {
            if (radios[j].checked) { score += parseInt(radios[j].value); }
        }
    }

    fetch("{{ route('quiz.save') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
        },
        body: JSON.stringify({ score: score })
    })
    .then(response => response.json())
    .then(data => {
        let resultBox = document.getElementById('result-box');
        resultBox.style.display = 'block';
        
        if (data.score >= 7) {
            resultBox.className = 'score-good';
            resultBox.innerHTML = `🌟 Excellent ${data.user_name} !<br>Vous avez obtenu ${data.score} / 10.<br><small style="color:white; font-weight:normal; font-size:0.7em;">(Score bien enregistré dans la base de données)</small>`;
        } else if (data.score >= 5) {
            resultBox.className = 'score-good';
            resultBox.innerHTML = `👍 Mission accomplie ${data.user_name} !<br>Vous avez obtenu ${data.score} / 10.<br><small style="color:white; font-weight:normal; font-size:0.7em;">(Score bien enregistré dans la base de données)</small>`;
        } else {
            resultBox.className = 'score-bad';
            resultBox.innerHTML = `⚠️ Échec de la mission ${data.user_name}...<br>Vous n'avez obtenu que ${data.score} / 10.<br><small style="color:white; font-weight:normal; font-size:0.7em;">(Score enregistré. Vous ferez mieux la prochaine fois !)</small>`;
        }
        
        btn.style.display = "none";
    })
    .catch(error => {
        alert("Erreur de communication avec le serveur principal (Base de données).");
        console.error(error);
        btn.innerText = "Réessayer la transmission";
        btn.disabled = false;
    });
});
</script>
@endsection
