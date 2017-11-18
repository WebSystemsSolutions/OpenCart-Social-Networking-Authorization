<?php

class ControllerAuthOauth extends Controller {

	protected $token;

	public function fblogin() {

		$code = $this->request->get['code'];

		$redirect = urlencode('http://reg.dix.ua/fb');

		if (!isset($code)) {

			$this->response->redirect('https://www.facebook.com/v2.10/dialog/oauth?client_id=1926182117646388&redirect_uri=' . $redirect . '');
		} else {

			$ch = curl_init();
			// GET запрос указывается в строке URL

			curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/v2.10/oauth/access_token?client_id=1926182117646388&redirect_uri=' . $redirect . '&client_secret=5ec2e368923b44af91ab22d2257d2f18&code=' . $code . '');
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Accept: application/json',
			));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($ch, CURLOPT_USERAGENT, 'PHP Bot');
			$data = curl_exec($ch);
			curl_close($ch);
			$data = json_decode($data);
		}
	}

	public function windowGlogin() {
		$this->response->setOutput($this->load->view('default/template/oauth/oauth.tpl'));

	}

	public function glogin() {
		//Підключаем конфиг
		include __DIR__ . '/config.php';

		//Підключаем скрипт
		$this->document->addScript('catalog/view/javascript/oauth/oauth.js');
		$code = $this->request->get['code'];

		// Отримуємо конфиги
		$redirect = $google['redirect_url'];
		$client_id = $google['client_id'];
		$client_secret = $google['client_secret'];

		//Створюємо редирект гоогла
		$redirect2 = 'https://accounts.google.com/o/oauth2/v2/auth?scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile&access_type=offline&include_granted_scopes=true&state=state_parameter_passthrough_value&' .
			'redirect_uri=' . $redirect . '&response_type=code&client_id=' . $client_id . '';

		if (!isset($code)) {
			$this->response->redirect($redirect2);
		} else {

			$ch = curl_init();
			// GET запрос указывается в строке URL

			curl_setopt($ch, CURLOPT_URL, 'https://accounts.google.com/o/oauth2/token');
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/x-www-form-urlencoded',
			));
			curl_setopt($ch, CURLOPT_POST, 1); //передача данных методом POST
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //теперь curl вернет нам ответ, а не выведет
			curl_setopt($ch, CURLOPT_POSTFIELDS, //тут переменные которые будут переданы методом POST
				http_build_query(array(
					'code' => $code,
					'client_id' => $client_id,
					'client_secret' => $client_secret,
					'redirect_uri' => $redirect, //это на случай если на сайте, к которому обращаемся проверяется была ли нажата кнопка submit, а не была ли оправлена форма
					'grant_type' => 'authorization_code',
				)));
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 40);
			curl_setopt($ch, CURLOPT_USERAGENT, 'PHP Bot');
			$data = curl_exec($ch);
			curl_close($ch);
			$data = json_decode($data);
			$this->getDataOauth($data->access_token);

		}
	}

	public function getDataOauth($google_access = NULL) {
		$ch = curl_init();
		// GET запрос указывается в строке URL
		if (empty($google_access)) {
			curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/me?fields=email,about,first_name,last_name&access_token=' . $this->request->post['access']);
		} else {
			curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/oauth2/v1/userinfo?access_token=' . $google_access);
		}
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Accept: application/json',
		));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_USERAGENT, 'PHP Bot');
		$data = curl_exec($ch);
		curl_close($ch);
		$data = json_decode($data);
		//var_dump($data);

		$this->load->model('oauth/oauth');

		$password_token_auth = md5($data->id . time());

		$this->session->data['password_token_auth'] = $password_token_auth;

		// var_dump($data);

		if (empty($google_access)) {
			$data = ['password' => $password_token_auth, 'firstname' => $data->first_name, 'lastname' => $data->last_name, 'email' => $data->email, 'id' => $data->id];
		} else {
			$data = ['password' => $password_token_auth, 'firstname' => $data->given_name, 'lastname' => $data->family_name, 'email' => $data->email, 'id' => $data->id];
		}
		var_dump($data);

		if (isset($data['email'])) {

			if ($this->model_oauth_oauth->validateEmailUserOauth($data['email']) && $this->model_oauth_oauth->validateEmailUser($data['email'])) {

				$this->signUpUser($data);
			} else {

				$this->setUserNew($data);
			}
			if (!empty($google_access)) {
				$this->response->setOutput('<script>window.close()</script>');
			}

		} else {

			return true;
		}

	}

	public function signUpUser($user) {

		$this->load->model('account/customer');

		if (!$this->customer->login($user['email'], "", true)) {

			$this->model_account_customer->addLoginAttempt($user['email']);
		} else {
			$this->load->model('oauth/oauth');

			$this->model_account_customer->deleteLoginAttempts($user['email']);

			$this->model_oauth_oauth->setToken($user['password'], $this->customer->getId());

		}
		return true;

	}

	public function successSignUp() {

		$this->load->model('account/customer');

		$this->load->model('oauth/oauth');

		$this->session->data['password_token_auth'];
		$res = $this->model_oauth_oauth->getOauth($this->session->data['password_token_auth']);

		if (empty($res['email'])) {

			$this->response->redirect($this->url->link('auth/oauth/error', '', 'SSL'));
		}

		if ($res['status'] == 0) {
			$this->response->redirect($this->url->link('auth/field', '', 'SSL'));
		} else {
			unset($this->session->data['password_token_auth']);
			$this->response->redirect($this->url->link('account/account', '', 'SSL'));
		}
	}

	public function setUserNew($user) {

		if (isset($user['telephone'])) {
			$user['telephone'] = $user['telephone'];
		} else {
			$user['telephone'] = '';
		}

		if (isset($user['fax'])) {
			$user['fax'] = $user['fax'];
		} else {
			$user['fax'] = '';
		}

		if (isset($user['company'])) {
			$user['company'] = $user['company'];
		} else {
			$user['company'] = '';
		}

		if (isset($user['website'])) {
			$user['website'] = $user['website'];
		} else {
			$user['website'] = '';
		}

		if (isset($user['address_1'])) {
			$user['address_1'] = $user['address_1'];
		} else {
			$user['address_1'] = '';
		}

		if (isset($user['address_2'])) {
			$user['address_2'] = $user['address_2'];
		} else {
			$user['address_2'] = '';
		}

		if (isset($user['postcode'])) {
			$user['postcode'] = $user['postcode'];
		} else {
			$user['postcode'] = '';
		}

		if (isset($user['city'])) {
			$user['city'] = $user['city'];
		} else {
			$user['city'] = '';
		}

		if (isset($user['country_id'])) {
			$user['country_id'] = (int) $user['country_id'];
		} else {
			$user['country_id'] = $this->config->get('config_country_id');
		}

		if (isset($user['zone_id'])) {
			$user['zone_id'] = (int) $user['zone_id'];
		} else {
			$user['zone_id'] = '';
		}

		$this->load->model('account/customer');
		//Регистрация
		$res = $this->model_oauth_oauth->validateEmailUser($user['email']);
		if ($res === false) {
			$customer_id = $this->model_account_customer->addCustomer($user);
		} else {

			if (!$this->customer->login($user['email'], "", true)) {

				$this->model_account_customer->addLoginAttempt($user['email']);

			} else {

				$this->model_account_customer->deleteLoginAttempts($user['email']);

			}
			$customer_id = $res;
		}
		$user['id_c'] = $customer_id;

		//Чистим попередню привязь якщо вона Є
		$this->model_oauth_oauth->deleteOauthUser($user['id']);

		$this->model_oauth_oauth->createNewOautUser($user);
		// Clear any previous login attempts for unregistered accounts.
		$this->model_account_customer->deleteLoginAttempts($user['email']);

		$this->customer->login($user['email'], $user['password']);

		unset($this->session->data['guest']);

		// Add to activity log
		$this->load->model('account/activity');

		$activity_data = array(
			'customer_id' => $customer_id,
			'name' => $user['firstname'] . ' ' . $user['lastname'],
		);

		$this->model_account_activity->addActivity('register', $activity_data);

	}

	public function config_fb() {

		$id_app_facebook = $this->config->get('oauth_id_app_facebook');
		$this->response->setOutput(json_encode(["facebook" => $id_app_facebook]));

	}

	public function error() {

		$data['heading_title'] = '';

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/oauth/error.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/oauth/error.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/oauth/eroor.tpl', $data));
		}
	}

}