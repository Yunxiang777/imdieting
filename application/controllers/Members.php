<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Members 使用者與會員前台操作
 * 
 * @property MembersModel $MembersModel
 * @property ProfileModel $ProfileModel
 */
class Members extends CI_Controller
{
	const MAIL_FORMAT_ERROR_CODE = '1001';
	const MAIL_FORMAT_ERROR_MESSAGE = 'Invalid email format';
	const LOGIN_AUTH_ERROR_CODE = '1004';
	const LOGIN_AUTH_ERROR_MESSAGE = 'Login authentication failed';
	const LOGIN_SUCCESS_CODE = '0000';
	const LOGIN_SUCCESS_MESSAGE = 'Login successful';
	const SIGNUP_SUCCESS_CODE = '0001';
	const SIGNUP_SUCCESS_MESSAGE = 'Sign up successful';
	const EMAIL_EXISTS_CODE = '1006';
	const EMAIL_EXISTS_MESSAGE = 'Email already exists';
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * 會員登入頁
	 *
	 */
	public function login()
	{
		if ($this->session->userdata('loggedIn')) {
			redirect('home');
			exit();
		}
		$data['rememberMeEmail'] = $this->getCookieEmailData();
		$this->load->view('layouts/layout', [
			'title' => 'Login Page',
			'content' => $this->load->view('login_view', $data, TRUE),
			'page' => 'login'
		]);
	}

	/**
	 * 會員註冊頁
	 *
	 */
	public function register()
	{
		if ($this->session->userdata('loggedIn')) {
			redirect('home');
			exit();
		}
		$this->load->view('layouts/layout', [
			'title' => 'Register Page',
			'content' => $this->load->view('register_view', NULL, TRUE),
			'page' => 'register'
		]);
	}

	/**
	 * 獲取cookie Email data
	 *
	 * @return string email
	 */
	private function getCookieEmailData(): string
	{
		$email = $this->input->cookie('rememberMeEmail');
		return !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : '';
	}

	/**
	 * 會員登出
	 *
	 */
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('login');
	}

	/**
	 * 註冊會員，ajax資料寫入
	 *
	 * @return void - 直接輸出 JSON 回應
	 */
	public function signUp()
	{
		try {
			// 過濾表單輸入格式
			$email = isset($_POST['email']) ? $_POST['email'] : '';
			$password = isset($_POST['password']) ? $_POST['password'] : '';
			if (empty($email) || empty($password)) {
				throw new Exception(FORM_FORMAT_ERROR_MESSAGE, FORM_FORMAT_ERROR_CODE);
			}
			// email過濾 與 密碼過濾
			$checkEmail = $this->checkEmail($email);
			if (!$checkEmail || strlen($password) < 6) {
				throw new Exception(self::MAIL_FORMAT_ERROR_MESSAGE, self::MAIL_FORMAT_ERROR_CODE);
			}
			// 帳號是否已存在
			$this->load->model('MembersModel');
			if ($this->MembersModel->checkEmailExisted($email)) {
				throw new Exception(self::EMAIL_EXISTS_MESSAGE, self::EMAIL_EXISTS_CODE);
			}
			$userData = array(
				'email' => $email,
				'password' => password_hash($password, PASSWORD_BCRYPT),
			);
			// 寫入資料
			$result = $this->MembersModel->signUp($userData);
			if (!$result) {
				throw new Exception(DATABASE_ERROR_MESSAGE, DATABASE_ERROR_CODE);
			}
			// 輸出回應
			$this->setOutput($this->setHttpCode(self::SIGNUP_SUCCESS_CODE), 'success', self::SIGNUP_SUCCESS_CODE, self::SIGNUP_SUCCESS_MESSAGE);
			exit();
		} catch (Exception $e) {
			$statusCode = $e->getCode() === 0 ? DEFAULT_ERROR_CODE : $e->getCode();
			$message = $e->getCode() === 0 ? DEFAULT_ERROR_MESSAGE : $e->getMessage();
			$this->setOutput($this->setHttpCode($statusCode), 'error', $statusCode, $message);
			exit();
		}
	}

	/**
	 * 登入會員驗證
	 *
	 * @return void 直接輸出 JSON 回應( $result 為 bool )
	 */
	public function auth()
	{
		try {
			// 過濾表單輸入格式
			$email = isset($_POST['email']) ? $_POST['email'] : '';
			$password = isset($_POST['password']) ? $_POST['password'] : '';
			$checkMeOut = isset($_POST['checkMeOut']) ? $_POST['checkMeOut'] : false;
			if (empty($email) || empty($password)) {
				throw new Exception(FORM_FORMAT_ERROR_MESSAGE, FORM_FORMAT_ERROR_CODE);
			}
			// email過濾 與 密碼過濾
			$checkEmail = $this->checkEmail($email);
			if (!$checkEmail || strlen($password) < 6) {
				throw new Exception(self::MAIL_FORMAT_ERROR_MESSAGE, self::MAIL_FORMAT_ERROR_CODE);
			}
			// 使用者驗證
			$this->load->model('MembersModel');
			$memberData = $this->MembersModel->auth($email);
			if (empty($memberData) || !password_verify($password, $memberData['password'])) {
				throw new Exception(self::LOGIN_AUTH_ERROR_MESSAGE, self::LOGIN_AUTH_ERROR_CODE);
			}
			//會員驗證成功
			$this->load->model('ProfileModel');
			$profileImg = $this->ProfileModel->getProfileImg($memberData['id']);
			//設置session
			$this->session->set_userdata(array(
				'loggedIn' => true,
				'memberId' => $memberData['id'],
				'memberEmail' => $email,
				'memberImg' => $profileImg ? unserialize($profileImg)['link'] : ''
			));
			//設置記住我cookie
			$this->setRememberMeCookie($email, $checkMeOut);
			//回應
			$this->setOutput($this->setHttpCode(self::LOGIN_SUCCESS_CODE), 'success', self::LOGIN_SUCCESS_CODE, self::LOGIN_SUCCESS_MESSAGE);
			exit();
		} catch (Exception $e) {
			$statusCode = $e->getCode() === 0 ? DEFAULT_ERROR_CODE : $e->getCode();
			$message = $e->getCode() === 0 ? DEFAULT_ERROR_MESSAGE : $e->getMessage();
			$this->setOutput($this->setHttpCode($statusCode), 'error', $statusCode, $message);
			exit();
		}
	}

	/**
	 * set output
	 *
	 * @param int $httpCode 
	 * @param string $status 
	 * @param string $code 
	 * @param string $message 
	 */
	private function setOutput(int $httpCode, string $status, string $statusCode, string $message)
	{
		$this->output
			->set_status_header($httpCode)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'code' => $statusCode, 'message' => $message, 'csrfToken' => $this->security->get_csrf_hash())))
			->_display();
	}

	/**
	 * 依訊息狀態碼指定回傳http狀態碼
	 *
	 * @param string $statusCode 依訊息狀態碼
	 * @return int http狀態碼
	 */
	private function setHttpCode(string $statusCode): int
	{
		$httpCode = '';
		switch ($statusCode) {
			case '1001':
			case '1002':
			case '1003':
				$httpCode = 400;
				break;
			case '1004':
				$httpCode = 401;
				break;
			case '0000':
				$httpCode = 200;
				break;
			case '0001':
				$httpCode = 201;
				break;
			case '1005':
				$httpCode = 500;
				break;
			case '1006':
				$httpCode = 409;
				break;
			default:
				$httpCode = 500;
				break;
		}
		return $httpCode;
	}

	/**
	 * 驗證email格式
	 *
	 * @param string $email 郵件地址
	 * @return bool
	 */
	private function checkEmail(string $email): bool
	{
		return (filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email) < 255);
	}

	/**
	 * 設置「記住我」Cookie
	 *
	 * @param string $email 要保存的郵件地址
	 * @param bool $checkMeOut 記住我
	 * @return void 設置Cookie
	 */
	private function setRememberMeCookie(string $email, bool $checkMeOut)
	{
		if ($checkMeOut) {
			$cookie_data = array(
				'name'   => 'rememberMeEmail',
				'value'  => $email,
				'expire' => '604800', // Cookie 的有效期一周
				'httponly' => true
			);
			set_cookie($cookie_data);
		} else {
			delete_cookie('rememberMeEmail');
		}
	}
}
