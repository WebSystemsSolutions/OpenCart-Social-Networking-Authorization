<?php
class ControllerModuleSocialAuth extends Controller {
 
	public function index() {
		echo false;
	}

	public function iframeGoogleLogin(){
        
        $redirect_href = $this->url->link('module/social_auth/iframeGoogleLogin', '', 'SSL');
        $redirect_after = $this->url->link('account/account', '', 'SSL');
        
		$google_app_id = $this->config->get('social_auth_google_app_id');
		$google_secret_key = $this->config->get('social_auth_google_secret_key');

        $link = 'https://accounts.google.com/o/oauth2/v2/auth?scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile&access_type=offline&include_granted_scopes=true&state=state_parameter_passthrough_value&' .
			'redirect_uri=' . urlencode($redirect_href) . '&response_type=code&client_id=' . $google_app_id . '';

        if (!isset($this->request->get['code'])) {

			$this->response->redirect($link);

		} else {

            $code = $this->request->get['code'];

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
					'client_id' => $google_app_id,
					'client_secret' => $google_secret_key,
					'redirect_uri' => $redirect_href, //это на случай если на сайте, к которому обращаемся проверяется была ли нажата кнопка submit, а не была ли оправлена форма
					'grant_type' => 'authorization_code',
				)));
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 40);
			curl_setopt($ch, CURLOPT_USERAGENT, 'PHP Bot');
			$data = curl_exec($ch);
			curl_close($ch);
			$data = json_decode($data);

			$token = $data->access_token;

            $url = 'https://www.googleapis.com/oauth2/v1/userinfo?access_token=' . $token;

            $result = $this->getCurl($url);

            if(isset($result->email)){
                    $this->load->model('account/customer');

                    $customer_info = $this->model_account_customer->getCustomerByEmail($result->email);

                    if ($customer_info) {
                        if(!$customer_info['approved']){
                            echo 'error approved'; exit;
                        } else {
                            // login customer

                            if ($this->customer->login($customer_info['email'], "", true)) {

                                $this->login($customer_info);

                                $this->response->setOutput('<script>
                                        window.opener.document.location = "'.$redirect_after.'";
                                        window.close();
                                        </script>');
                                        
                            } else {
                                $this->model_account_customer->deleteLoginAttempts($customer_info['email']);
                                echo 'not login'; exit;
                            }
                        }
                        
                    } else {
                        // add customer

                        $password_auth = md5(time());

                        $customer = array(
                            'firstname' => $result->given_name,
                            'lastname' => $result->family_name,
                            'email' => $result->email,
                            'telephone' => '',
                            'fax' => '',
                            'password' => $password_auth,
                            'company' => '',
                            'address_1' => '',
                            'address_2' => '',
                            'city' => '',
                            'postcode' => '',
                            'country_id' => 104,
                            'zone_id' => 0,
                        );

                        $customer_id = $this->model_account_customer->addCustomer($customer);

                        if($customer_id){

                            $customer_info = $this->model_account_customer->getCustomer($customer_id);

                            if ($this->customer->login($customer_info['email'], "", true)) {

                                $this->login($customer_info);

                                $this->response->setOutput('<script>
                                        window.opener.document.location = "'.$redirect_after.'";
                                        window.close();
                                        </script>');

                            } else {
                                $this->model_account_customer->deleteLoginAttempts($customer_info['email']);
                                echo 'not login'; exit;
                                
                            }
                        
                        } else {
                            echo 'not register customer'; exit;
                        }
                    }
            
            } else {

                echo 'error 5005';
            
            }
        }
    }
    
	public function ajaxFacebookLogin(){
        $json = array();
        $json['status'] = false;
        $json['redirect'] = false;
        $json['message'] = '';

        $redirect_after = $this->url->link('account/account', '', 'SSL');

        $data = $this->request->get;

        if($this->customer->isLogged()){

            $json['message'] = 'login OK';
            $json['status'] = true;
            $json['redirect'] = $redirect_after;
        
        } elseif(isset($data['accessToken'])){

            $url = 'https://graph.facebook.com/me?fields=email,about,first_name,last_name&access_token=' . $data['accessToken'];

            $result = $this->getCurl($url);

            if(isset($result->error)){
                $json['message'] = @$result->error->message;
            }

            if(isset($result->id)){
                if(isset($result->email)){

                    $this->load->model('account/customer');

                    $customer_info = $this->model_account_customer->getCustomerByEmail($result->email);

                    if ($customer_info) {
                        if(!$customer_info['approved']){
                            $json['message'] = 'error approved';
                        } else {
                            // login customer

                            if ($this->customer->login($customer_info['email'], "", true)) {

                                $this->login($customer_info);

                                $json['message'] = 'login OK';
                                $json['status'] = true;
                                $json['redirect'] = $redirect_after;

                            } else {
                                $json['message'] = 'not login';
                                $this->model_account_customer->deleteLoginAttempts($customer_info['email']);
                            }
                        }
                        
                    } else {
                        // add customer

                        $password_auth = md5(time());

                        $customer = array(
                            'firstname' => $result->first_name,
                            'lastname' => $result->last_name,
                            'email' => $result->email,
                            'telephone' => '',
                            'fax' => '',
                            'password' => $password_auth,
                            'company' => '',
                            'address_1' => '',
                            'address_2' => '',
                            'city' => '',
                            'postcode' => '',
                            'country_id' => 104,
                            'zone_id' => 0,
                        );

                        $customer_id = $this->model_account_customer->addCustomer($customer);

                        if($customer_id){

                            $customer_info = $this->model_account_customer->getCustomer($customer_id);

                            if ($this->customer->login($customer_info['email'], "", true)) {

                                $this->login($customer_info);

                                $json['message'] = 'login OK';
                                $json['status'] = true;
                                $json['redirect'] = $redirect_after;

                            } else {

                                $json['message'] = 'not login';
                                $this->model_account_customer->deleteLoginAttempts($customer_info['email']);
                            }
                        } else {
                            $json['message'] = 'not register customer';
                        }
                    }
                } else {
                    $json['message'] = 'not find email';
                }

            } else {
                $json['message'] = 'not find user';
            }

            $json['data'] = $result;
            
        }

        $this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
    }
    
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
    
    protected function getCurl($url){

        $ch = curl_init();
        // GET запрос указывается в строке URL

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
