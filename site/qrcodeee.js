
	var siteLink = window.location.href;  // Récupère la valeur de votre variable

        var imageElement = document.getElementById("myImage");
        imageElement.src = "https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=" + encodeURIComponent(siteLink);
        // Ajoute la valeur de la variable à la fin de la source de l'image
        // Utilisez encodeURIComponent pour s'assurer que l'URL est correctement encodée

	
