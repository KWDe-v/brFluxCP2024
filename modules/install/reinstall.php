<?php
if (!defined('FLUX_ROOT')) exit;

$title = 'Reinstalar banco de dados';

if (count($_POST) && $params->get('reinstall')) {
	$loginDbFiles   = glob(FLUX_DATA_DIR.'/logs/schemas/logindb/*/*.txt');
	$charMapDbFiles = glob(FLUX_DATA_DIR.'/logs/schemas/charmapdb/*/*.txt');
	
	foreach (array($loginDbFiles, $charMapDbFiles) as $dbDir) {
		if ($dbDir) {
			foreach ($dbDir as $file) {
				unlink($file);
			}
			//Tentamos desvincular o diretório, mas não vamos exibir erro se
			// ainda há arquivos nele.
			@rmdir($dbDir);
		}
	}
	
	$this->redirect();
}
?>
