<?php

class ControllerAuthField extends Controller {
    private $error = array();

    public function index(){

        if(!isset($this->session->data['password_token_auth'])){
            $this->response->redirect($this->url->link('account/account', '', 'SSL'));
        }

        $this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment.js');
        $this->document->addScript('catalog/view/javascript/jquery/datetimepicker/locale/'.$this->session->data['language'].'.js');
        $this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
        $this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');

        $this->load->model('oauth/field');
        $data = array();

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->load->model('oauth/oauth');

            $this->model_oauth_field->addUserRequestField($this->request->post,$this->customer->getId());
            $this->model_oauth_oauth->setStatus(1,$this->customer->getId());

            unset($this->session->data['password_token_auth']);
            $this->response->redirect($this->url->link('account/account', '', 'SSL'));
            //echo 'true';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home')
        );

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_account'),
            'href'      => $this->url->link('account/account', '', 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_edit'),
            'href'      => $this->url->link('account/edit', '', 'SSL')
        );

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['firstname'])) {
            $data['error_firstname'] = $this->error['firstname'];
        } else {
            $data['error_firstname'] = '';
        }

        if (isset($this->error['lastname'])) {
            $data['error_lastname'] = $this->error['lastname'];
        } else {
            $data['error_lastname'] = '';
        }

        if (isset($this->error['email'])) {
            $data['error_email'] = $this->error['email'];
        } else {
            $data['error_email'] = '';
        }

        if (isset($this->error['telephone'])) {
            $data['error_telephone'] = $this->error['telephone'];
        } else {
            $data['error_telephone'] = '';
        }

        if (isset($this->error['password'])) {
            $data['error_password'] = $this->error['password'];
        } else {
            $data['error_password'] = '';
        }

        $data['action'] = $this->url->link('auth/field', '', 'SSL');


        $data['heading_title'] = 'Пожалуста ведите дополнительние даные';
        $data['button_back'] = 'Назад';
        $data['button_continue'] = 'Продолжить';
        $data['entry_firstname'] = 'Имя';
        $data['entry_lastname'] = 'Фамилия';
        $data['entry_email'] = 'Email';
        $data['entry_telephone'] = 'Телефон';
        $data['entry_password'] = 'Пароль';
        $data['text_your_details'] = '';

        $model = $this->model_oauth_field->getUser($this->customer->getId());

        $data['lastname'] = $model['lastname'];
        $data['firstname'] = $model['firstname'];
        $data['email'] = $model['email'];
        $data['telephone'] = $model['telephone'];



        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/oauth/field-request.tpl')) {
            $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/oauth/field-request.tpl', $data));
        } else {
            $this->response->setOutput($this->load->view('default/template/oauth/field-request.tpl', $data));
        }
    }


    protected function validate() {
        if ((utf8_strlen(trim($this->request->post['firstname'])) < 1) || (utf8_strlen(trim($this->request->post['firstname'])) > 32)) {
            $this->error['firstname'] = 'er';
        }

        if ((utf8_strlen(trim($this->request->post['lastname'])) < 1) || (utf8_strlen(trim($this->request->post['lastname'])) > 32)) {
            $this->error['lastname'] = 'er';
        }

        if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match($this->config->get('config_mail_regexp'), $this->request->post['email'])) {
            $this->error['email'] = 'er';
        }

        if (($this->customer->getEmail() != $this->request->post['email']) && $this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
            $this->error['warning'] = 'er';
        }

        if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
            $this->error['telephone'] = 'er';
        }

        if ((utf8_strlen($this->request->post['password']) < 6) || (utf8_strlen($this->request->post['password']) > 32)) {
            $this->error['password'] = 'er';
        }
        /*
        // Custom field validation
        $this->load->model('account/custom_field');

        $custom_fields = $this->model_account_custom_field->getCustomFields($this->config->get('config_customer_group_id'));

        foreach ($custom_fields as $custom_field) {
            if (($custom_field['location'] == 'account') && $custom_field['required'] && empty($this->request->post['custom_field'][$custom_field['custom_field_id']])) {
                $this->error['custom_field'][$custom_field['custom_field_id']] = sprintf($this->language->get('error_custom_field'), $custom_field['name']);
            }
        }
        */

        return !$this->error;
    }

}

?>