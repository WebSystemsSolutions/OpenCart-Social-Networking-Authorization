<?php

//Google Конфіг

$google = ['client_secret' => $this->config->get('oauth_secret_key'),
	'client_id' => $this->config->get('oauth_id_app'),
	'redirect_url' => $this->config->get('oauth_calback')];

?>
