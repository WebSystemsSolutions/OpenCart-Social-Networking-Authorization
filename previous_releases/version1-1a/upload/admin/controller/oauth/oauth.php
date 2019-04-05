<?php
class ControllerOauthOauth extends Controller {
	public function index() {

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$this->model_setting_setting->editSetting('oauth', $this->request->post);

			$this->session->data['success'] = 'success';

			$this->response->redirect($this->url->link('oauth/oauth', 'token=' . $this->session->data['token'], 'SSL'));

		}

		$this->load->language('oauth/oauth');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('oauth/oauth');

		$this->getForm();

	}

	protected function getForm() {
//General
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

//head
		$data['heading_title'] = $this->language->get('heading_title');

//Data

		if (isset($this->request->post['oauth_calback'])) {
			$data['calback'] = $this->request->post['oauth_calback'];
		} else {
			$data['calback'] = $this->config->get('oauth_calback');
		}

		if (isset($this->request->post['oauth_secret_key'])) {
			$data['secret_key'] = $this->request->post['oauth_secret_key'];
		} else {
			$data['secret_key'] = $this->config->get('oauth_secret_key');
		}

		if (isset($this->request->post['oauth_id_app'])) {
			$data['id_app'] = $this->request->post['oauth_id_app'];
		} else {
			$data['id_app'] = $this->config->get('oauth_id_app');
		}

		if (isset($this->request->post['oauth_id_app_facebook'])) {
			$data['id_app_facebook'] = $this->request->post['oauth_id_app_facebook'];
		} else {
			$data['id_app_facebook'] = $this->config->get('oauth_id_app_facebook');
		}

		if (isset($this->request->post['oauth_f_opt'])) {
			$data['f_opt'] = $this->request->post['oauth_f_opt'];
		} else {
			$data['f_opt'] = $this->config->get('oauth_f_opt');
		}
		$data['txt'] = file_get_contents('https://raw.githubusercontent.com/WebSystemsSolutions/OpencartSocialnetworkingAutorization/master/readme.txt');

		$data['action'] = $this->url
			->link('oauth/oauth', 'token=' . $this->session->data['token'], 'SSL');

		$this->response->setOutput($this->load->view('oauth/main.tpl', $data));

	}
}