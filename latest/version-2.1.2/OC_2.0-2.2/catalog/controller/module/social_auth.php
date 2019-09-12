<?php
class ControllerModuleSocialAuth extends Controller {
    private $error = array();
    
    public function index() {
        echo 'false';
    }
    
    // form for adding non-existing fields
    public function register() {
        $this->load->language('account/edit');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('account/customer');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->register_validate()) {

            $customer = array(
                    'firstname' => $this->request->post['firstname'],
                    'lastname' => $this->request->post['lastname'],
                    'email' => $this->request->post['email'],
                    'telephone' => '',
                    'fax' => '',
                    'password' => md5(time()),
                    'company' => '',
                    'address_1' => '',
                    'address_2' => '',
                    'city' => '',
                    'postcode' => '',
                    'country_id' => 104,
                    'zone_id' => 0,
                    'social_id' => $this->request->post['social_id'],
                );

            $customer_id = $this->model_account_customer->addCustomer($customer);

            $this->db->query("UPDATE " . DB_PREFIX . "customer SET social_id = '" . (string)$customer['social_id'] . "' WHERE customer_id = '" . (int)$customer_id . "'");

            if($customer_id){
                $customer_info = $this->model_account_customer->getCustomer($customer_id);

                if ($this->customer->login($customer_info['email'], "", true)) {
                    $this->login($customer_info);
                    $this->response->redirect($this->url->link('account/account', '', 'SSL'));
                }
            }
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home')
        );

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_edit'),
            'href'      => $this->url->link('account/edit', '', 'SSL')
        );

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_your_details'] = $this->language->get('text_your_details');
        $data['text_additional'] = $this->language->get('text_additional');
        $data['text_select'] = $this->language->get('text_select');
        $data['text_loading'] = $this->language->get('text_loading');

        $data['entry_firstname'] = $this->language->get('entry_firstname');
        $data['entry_lastname'] = $this->language->get('entry_lastname');
        $data['entry_email'] = $this->language->get('entry_email');
        $data['entry_telephone'] = $this->language->get('entry_telephone');
        $data['entry_fax'] = $this->language->get('entry_fax');

        $data['button_continue'] = $this->language->get('button_continue');
        $data['button_back'] = $this->language->get('button_back');
        $data['button_upload'] = $this->language->get('button_upload');

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

        $data['action'] = $this->url->link('module/social_auth/register', '', 'SSL');

        if ($this->request->server['REQUEST_METHOD'] != 'POST') {
            $customer_info = $this->session->data['social_auth'];
        }

        if (isset($this->request->post['firstname'])) {
            $data['firstname'] = $this->request->post['firstname'];
        } elseif (!empty($customer_info)) {
            $data['firstname'] = $customer_info['firstname'];
        } else {
            $data['firstname'] = '';
        }

        if (isset($this->request->post['lastname'])) {
            $data['lastname'] = $this->request->post['lastname'];
        } elseif (!empty($customer_info)) {
            $data['lastname'] = $customer_info['lastname'];
        } else {
            $data['lastname'] = '';
        }

        if (isset($this->request->post['email'])) {
            $data['email'] = $this->request->post['email'];
        } elseif (!empty($customer_info)) {
            $data['email'] = $customer_info['email'];
        } else {
            $data['email'] = '';
        }

        if (isset($this->request->post['telephone'])) {
            $data['telephone'] = $this->request->post['telephone'];
        } elseif (!empty($customer_info)) {
            $data['telephone'] = $customer_info['telephone'];
        } else {
            $data['telephone'] = '';
        }
        
        if (isset($this->request->post['social_id'])) {
            $data['social_id'] = $this->request->post['social_id'];
        } elseif (!empty($customer_info)) {
            $data['social_id'] = $customer_info['social_id'];
        } else {
            $data['social_id'] = '';
        }

        $data['back'] = $this->url->link('common/home', '', 'SSL');

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/social_auth_register.tpl')) {
            $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/module/social_auth_register.tpl', $data));
        } else {
            $this->response->setOutput($this->load->view('default/template/module/social_auth_register.tpl', $data));
        }
    }
    
    // validate fiels register function
    protected function register_validate() {
        if ((utf8_strlen(trim($this->request->post['firstname'])) < 1) || (utf8_strlen(trim($this->request->post['firstname'])) > 32)) {
            $this->error['firstname'] = $this->language->get('error_firstname');
        }
        if ((utf8_strlen(trim($this->request->post['lastname'])) < 1) || (utf8_strlen(trim($this->request->post['lastname'])) > 32)) {
            $this->error['lastname'] = $this->language->get('error_lastname');
        }
        if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match($this->config->get('config_mail_regexp'), $this->request->post['email'])) {
            $this->error['email'] = $this->language->get('error_email');
        }
        if (($this->customer->getEmail() != $this->request->post['email']) && $this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
            $this->error['warning'] = $this->language->get('error_exists');
        }
        if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
            //$this->error['telephone'] = $this->language->get('error_telephone');
        }
        return !$this->error;
    }
    
    // method login to Google with  oauth2
    public function iframeGoogleLogin(){
        
        $redirect_href = HTTPS_SERVER.'gp_login';
        
        $google_app_id = $this->config->get('social_auth_google_app_id');
        $google_secret_key = $this->config->get('social_auth_google_secret_key');

        $link = 'https://accounts.google.com/o/oauth2/v2/auth?scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile&access_type=offline&include_granted_scopes=true&state=state_parameter_passthrough_value&' .
            'redirect_uri=' . urlencode($redirect_href) . '&response_type=code&client_id=' . $google_app_id . '';

        if (!isset($this->request->get['code'])) {
            // not find code
            $this->response->redirect($link);

        } else {

            $code = $this->request->get['code'];

            $data = $this->getTokenWithCurl('https://accounts.google.com/o/oauth2/token',array(
                    'code' => $code,
                    'client_id' => $google_app_id,
                    'client_secret' => $google_secret_key,
                    'redirect_uri' => $redirect_href, //это на случай если на сайте, к которому обращаемся проверяется была ли нажата кнопка submit, а не была ли оправлена форма
                    'grant_type' => 'authorization_code',
                ));
            // get token
            $token = $data->access_token;

            $url = 'https://www.googleapis.com/oauth2/v1/userinfo?access_token=' . $token;

            $result = $this->getCurl($url);

            if(isset($result->id)){

                $customer = array(
                    'firstname' => @$result->given_name,
                    'lastname' => @$result->family_name,
                    'email' => @$result->email,
                    'telephone' => '',
                    'fax' => '',
                    'password' => md5(time()),
                    'company' => '',
                    'address_1' => '',
                    'address_2' => '',
                    'city' => '',
                    'postcode' => '',
                    'country_id' => 104,
                    'zone_id' => 0,
                    'social_id' => $result->id,
                );
                
                $return_data = $this->toLoginRegister($customer);

                if($return_data['status']){

                    echo('<script>
                        window.opener.document.location = "'.$return_data['redirect'].'";
                        window.close();
                        </script>');
                
                } else {
                    echo $return_data['text']; exit;
                }
            
            } else {
                echo 'not find user'; exit;
            }
        }
    }

    // method login to Facebook with  oauth2
    public function iframeFacebookLogin(){
        
        $redirect_href = HTTPS_SERVER.'fb_login';

        $facebook_app_id = $this->config->get('social_auth_facebook_app_id');
        $facebook_secret_key = $this->config->get('social_auth_facebook_secret_key');

        $link = 'https://www.facebook.com/v3.2/dialog/oauth?client_id=' . $facebook_app_id . '&redirect_uri=' . urlencode($redirect_href) . '&auth_type=rerequest&scope=email';

        if (!isset($this->request->get['code'])) {

            $this->response->redirect($link);

        } else {

            $code = $this->request->get['code'];

            $url_token = 'https://graph.facebook.com/v3.2/oauth/access_token?client_id='.$facebook_app_id.'&redirect_uri=' . urlencode($redirect_href) . '&client_secret='.$facebook_secret_key.'&code='.$code.'';

            $data = $this->getCurl($url_token);

            $url = 'https://graph.facebook.com/me?fields=email,about,first_name,last_name&access_token=' . $data->access_token;

            $result = $this->getCurl($url);

            if(isset($result->error)){
                echo @$result->error->message; exit;
            }

            if(isset($result->id)){

                $data_customer = array(
                    'firstname' => @$result->first_name,
                    'lastname' => @$result->last_name,
                    'email' => @$result->email,
                    'telephone' => '',
                    'fax' => '',
                    'password' => md5(time()),
                    'company' => '',
                    'address_1' => '',
                    'address_2' => '',
                    'city' => '',
                    'postcode' => '',
                    'country_id' => 104,
                    'zone_id' => 0,
                    'social_id' => $result->id,
                );

                $return_data = $this->toLoginRegister($data_customer);

                if($return_data['status']){

                    echo('<script>
                        window.opener.document.location = "'.$return_data['redirect'].'";
                        window.close();
                        </script>');
                
                } else {
                    echo $return_data['text']; exit;
                }
            } else {
                echo 'not find user'; exit;
            }
        }
    }

    public function iframeInstagramLogin(){
        
        $redirect_href = HTTPS_SERVER.'insta_login';
        
        $insatagram_client_id = trim($this->config->get('social_auth_insatagram_client_id'));
        $insatagram_secret_key = trim($this->config->get('social_auth_insatagram_secret_key'));

        $link = 'https://api.instagram.com/oauth/authorize/?client_id=' . $insatagram_client_id . '&redirect_uri=' . urlencode($redirect_href) . '&response_type=code';

        if (!isset($this->request->get['code'])) {

            $this->response->redirect($link);

        } else {

            $code = $this->request->get['code'];

            $data = $this->getTokenWithCurl('https://api.instagram.com/oauth/access_token',array(
                    'code' => $code,
                    'client_id' => $insatagram_client_id,
                    'client_secret' => $insatagram_secret_key,
                    'redirect_uri' => $redirect_href, //это на случай если на сайте, к которому обращаемся проверяется была ли нажата кнопка submit, а не была ли оправлена форма
                    'grant_type' => 'authorization_code',
                ));

            $token = $data->access_token;

            $url = 'https://api.instagram.com/v1/users/self/?access_token=' . $token;

            $result = $this->getCurl($url);

            if(isset($result->data->id)){

                $customer = array(
                    'firstname' => @$result->data->username,
                    'lastname' => @$result->data->full_name,
                    'email' => '',
                    'telephone' => '',
                    'fax' => '',
                    'password' => md5(time()),
                    'company' => '',
                    'address_1' => '',
                    'address_2' => '',
                    'city' => '',
                    'postcode' => '',
                    'country_id' => 104,
                    'zone_id' => 0,
                    'social_id' => $result->data->id,
                );
                
                $return_data = $this->toLoginRegister($customer);

                if($return_data['status']){

                    echo('<script>
                        window.opener.document.location = "'.$return_data['redirect'].'";
                        window.close();
                        </script>');
                
                } else {
                    echo $return_data['text']; exit;
                }
            } else {
                echo 'not find user'; exit;
            }
        }
    }

    // login or redister user
    private function toLoginRegister($customer){
        
        $redirect_after = $this->url->link('account/account', '', 'SSL');
        $redirect_after_register = $this->url->link('module/social_auth/register', '', 'SSL');
        
        if($customer['social_id']){
            $this->load->model('account/customer');

            $customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE social_id = '" . (string)$customer['social_id'] . "'");
            
            $customer_info = $customer_query->row;
            
            if ($customer_info) {
                if(!$customer_info['approved']){
                    return ['status' => false, 'text' => 'not approved'];
                } else {
                    // login customer
                    if ($this->customer->login($customer_info['email'], "", true)) {
                        $this->login($customer_info);

                        return ['status' => true, 'text' => 'login','redirect' => $redirect_after];

                    } else {
                        return ['status' => false, 'text' => 'not login'];
                        $this->model_account_customer->deleteLoginAttempts($customer_info['email']);
                    }
                }
            } else {
                // add customer

                if($customer['email']){
                    $customer_id = $this->model_account_customer->addCustomer($customer);

                    $this->db->query("UPDATE " . DB_PREFIX . "customer SET social_id = '" . (string)$customer['social_id'] . "' WHERE customer_id = '" . (int)$customer_id . "'");

                    if($customer_id){

                        $customer_info = $this->model_account_customer->getCustomer($customer_id);

                        if ($this->customer->login($customer_info['email'], "", true)) {

                            $this->login($customer_info);

                            return ['status' => true, 'text' => 'login','redirect' => $redirect_after];

                        } else {
                            return ['status' => false, 'text' => 'not login'];
                            $this->model_account_customer->deleteLoginAttempts($customer_info['email']);
                        }
                    } else {
                        return ['status' => false, 'text' => 'not register customer'];
                    }
                } else {

                    $this->session->data['social_auth'] = $customer;

                    return ['status' => true, 'text' => 'login','redirect' => $redirect_after_register];
                    
                    // not email
                }
            }
        }
    }
    
    // method unset guest data with login 
    protected function login($customer_info){

        $this->load->model('account/customer');
        $this->model_account_customer->addLoginAttempt($customer_info['email']);

        // login OK
        unset($this->session->data['guest']);
        
        // Default Shipping Address
        $this->load->model('account/address');
        if ($this->config->get('config_tax_customer') == 'payment') {
            $this->session->data['payment_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
        }
        if ($this->config->get('config_tax_customer') == 'shipping') {
            $this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
        }
        // Add to activity log
        $this->load->model('account/activity');

        $activity_data = array(
            'customer_id' => $this->customer->getId(),
            'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
        );

        $this->model_account_activity->addActivity('login', $activity_data);
    }


    // get curl POST
    private function getTokenWithCurl($url = '',$data = array()){
        $ch = curl_init();
        $fields = http_build_query($data);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded',
        ));
        curl_setopt($ch, CURLOPT_POST, 1); //передача данных методом POST
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //теперь curl вернет нам ответ, а не выведет
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 40);
        curl_setopt($ch, CURLOPT_USERAGENT, 'PHP Bot');
        $data = curl_exec($ch);
        curl_close($ch);
        
        return json_decode($data);
    }
    
    // get curl GET
    protected function getCurl($url){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);

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

        return $data;
    }

}
