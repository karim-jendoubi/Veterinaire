<?php
	// Initialiser la session
	session_start();
	
	// Détruire la session.
	if(session_destroy())
	{
		// Redirection vers la page de connexion
		?>
		<script type="text/javascript">
            history.go(-1)
		</script>
		<?php
	}
?>