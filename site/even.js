  document.getElementById("thresholdForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Empêche l'envoi du formulaire

    // Récupérer les valeurs des seuils
    var poidsMin = parseFloat(document.getElementById("poidsMin").value);
    var poidsMax = parseFloat(document.getElementById("poidsMax").value);
    var frequenceMin = parseFloat(document.getElementById("frequenceMin").value);
    var frequenceMax = parseFloat(document.getElementById("frequenceMax").value);
    var caloriesMin = parseFloat(document.getElementById("caloriesMin").value);
    var caloriesMax = parseFloat(document.getElementById("caloriesMax").value);

  // Mettre à jour les options des graphiques
    poidsChart.options.scales.y.min = poidsMin;
    poidsChart.options.scales.y.max = poidsMax;
    frequenceChart.options.scales.y.min = frequenceMin;
    frequenceChart.options.scales.y.max = frequenceMax;
    caloriesChart.options.scales.y.min = caloriesMin;
    caloriesChart.options.scales.y.max = caloriesMax;


    // Mettre à jour les graphiques
    poidsChart.update();
    frequenceChart.update();
    caloriesChart.update();
  });
