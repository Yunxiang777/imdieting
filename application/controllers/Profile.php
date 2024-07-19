<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Profile 會員資料頁
 * 
 * @property ProfileModel $ProfileModel
 */
class Profile extends CI_Controller
{
	private $memberId;
	const UPDATE_PROFILE_SUCCESS_CODE = '0000';
	const UPDATE_PROFILE_SUCCESS_MESSAGE = 'Update Profile Success!';
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('loggedIn')) {
			redirect('home');
			exit();
		}
		$this->memberId = $this->session->userdata('memberId');
	}

	/**
	 * 會員資料頁
	 *
	 */
	public function main()
	{
		$data['profileData'] = $this->getProfileData();
		$this->load->view('layouts/layout', [
			'title' => 'Profile Set',
			'content' => $this->load->view('profile_view', $data, TRUE),
			'page' => 'profile'
		]);
	}

	/**
	 * 修改會員資料
	 *
	 * @return void - 直接輸出 JSON 回應( $result 為 bool )
	 */
	public function updateProfileData()
	{
		try {
			// 表單過濾
			$profileData = isset($_POST['data']) ? json_decode($_POST['data'], TRUE) : array();
			if (empty($profileData)) {
				throw new Exception(FORM_FORMAT_ERROR_MESSAGE, FORM_FORMAT_ERROR_CODE);
			}
			// 表單過濾
			$checkForm = $this->checkForm($profileData);
			if (!$checkForm) {
				throw new Exception(FORM_FORMAT_ERROR_MESSAGE, FORM_FORMAT_ERROR_CODE);
			}
			// 處理圖片數據
			$profileData = $this->processImg($profileData);
			// 更新會員資料
			$this->load->model('ProfileModel');
			$result = $this->ProfileModel->updateProfileData($this->memberId, $profileData);
			if (!$result) {
				throw new Exception(DATABASE_ERROR_CODE, DATABASE_ERROR_MESSAGE);
			}
			// 輸出回應
			$this->output
				->set_status_header($this->setHttpCode(self::UPDATE_PROFILE_SUCCESS_CODE))
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode(array('status' => 'success', 'code' => self::UPDATE_PROFILE_SUCCESS_CODE, 'message' => self::UPDATE_PROFILE_SUCCESS_MESSAGE, 'csrfToken' => $this->security->get_csrf_hash())))
				->_display();
			exit();
		} catch (Exception $e) {
			$statusCode = $e->getCode() === 0 ? DEFAULT_ERROR_CODE : $e->getCode();
			$message = $e->getCode() === 0 ? DEFAULT_ERROR_MESSAGE : $e->getMessage();
			$httpCode = $this->setHttpCode($statusCode);
			$this->output
				->set_status_header($httpCode)
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode(array('status' => 'error', 'code' => $statusCode, 'message' => $message, 'csrfToken' => $this->security->get_csrf_hash())))
				->_display();
			exit();
		}
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
			case '1003':
				$httpCode = 400;
				break;
			case '0000':
				$httpCode = 200;
				break;
			default:
				$httpCode = 500;
				break;
		}
		return $httpCode;
	}

	/**
	 * 檢查表單
	 *
	 * @param $data 表單提交
	 * @return bool
	 */
	private function checkForm(array $data): bool
	{
		$valid = true;
		foreach ($data as $key => $value) {
			switch ($key) {
				case 'email':
					$valid = (filter_var($value, FILTER_VALIDATE_EMAIL) && strlen($value) < 255);
					break;
				case 'phone':
					$valid = preg_match("/^\d{10}$/", $value);
					break;
				case 'age':
					$valid = preg_match("/^\d{1,3}$/", $value);
					break;
				case 'height':
					$valid = preg_match("/^\d{1,3}$/", $value);
					break;
				case 'weight':
					$valid = preg_match("/^\d{1,3}(\.\d{1,2})?$/", $value);
					break;
				case 'gender':
					$valid = ($value === 'male' || $value === 'female');
					break;
				case 'img':
					$valid = in_array($value['type'], ['imgur', 'default', 'base64']);
					break;
				case 'tdee':
					$valid = filter_var($value, FILTER_VALIDATE_INT);
					break;
				case 'work':
					$valid = in_array($value, ['low', 'medium', 'high']);
					break;
				default:
					break;
			}
			if (!$valid) {
				break;
			}
		}
		return $valid;
	}

	/**
	 * 提取會員資料
	 *
	 * @return array - 會員email與個人資料
	 */
	private function getProfileData()
	{
		$this->load->model('ProfileModel');
		$profileData = $this->ProfileModel->getProfileData($this->memberId);
		$profileData['img'] = $this->formatPorfileImg($profileData['img']);
		return $profileData;
	}

	/**
	 * 格式化使用者圖片url
	 *
	 * @param string $img
	 * @return string 圖片url
	 */
	private function formatPorfileImg(string $img): string
	{
		return $img ? unserialize($img)['link'] : '';
	}

	/**
	 * 處理圖片數據
	 *
	 * @param array $profileData 傳入的個人資料
	 * @return array 處理後的個人資料
	 */
	private function processImg(array $profileData): array
	{
		$this->load->helper('image_helper');
		$imageHelper = new Image_helper();
		switch ($profileData['img']['type']) {
			case 'default':
				$profileData['img'] = '';
				break;
			case 'base64':
				$this->load->model('ProfileModel');
				$profileImg = $this->ProfileModel->getProfileImg($this->memberId);
				if ($profileImg) {
					$profileImg = unserialize($profileImg);
					if ($imageHelper->deleteImg($profileImg['deletehash'])) {
						$updateResult = $imageHelper->uploadImg($profileData['img']['src']);
						$updateResult ? ($profileData['img'] = $updateResult) : null;
					}
				} else {
					$profileData['img'] = $imageHelper->uploadImg($profileData['img']['src']);
				}
				break;
			case 'imgur':
				unset($profileData['img']);
				break;
			default:
				break;
		}
		return $profileData;
	}
}
