<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Diet 會員飲食資料
 * 
 * @property DietModel $DietModel
 * @property ProfileModel $ProfileModel
 */
class Diet extends CI_Controller
{
    const RECORD_MEAL_SUCCESS_CODE = '0000';
    const RECORD_MEAL_SUCCESS_MESSAGE = 'Recode Meal Success!';
    private $memberId;
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
     * 飲食紀錄主頁面
     *
     */
    public function main()
    {
        $content['dietRecord'] = $this->getDietRecord($this->memberId);
        $content['tdee'] = $this->getTdee($this->memberId);
        $this->load->view('layouts/layout', [
            'title' => 'Diet',
            'content' => $this->load->view('diet/diet_view', $content, TRUE),
            'page' => 'diet'
        ]);
    }

    /**
     * 新增飲食紀錄
     */
    public function addMeal()
    {
        try {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('food', 'Food', 'required|alpha');
            $this->form_validation->set_rules('calories', 'Calories', 'required|integer');
            if ($this->form_validation->run() == FALSE) {
                throw new Exception(FORM_FORMAT_ERROR_MESSAGE, FORM_FORMAT_ERROR_CODE);
            }
            $this->load->model('DietModel');
            $date = date("Y-m-d");
            $dietData = array(
                'member_id' => $this->memberId,
                'food' => $_POST['food'],
                'calories' => $_POST['calories'],
                'date' => $date
            );
            $mealId = $this->DietModel->addMeal($dietData);
            if (!$mealId) {
                throw new Exception(DATABASE_ERROR_CODE, DATABASE_ERROR_MESSAGE);
            }
            $data = array(
                'mealId' => $mealId,
                'date' => $date
            );
            // 輸出回應
            $this->setOutput($this->setHttpCode(self::RECORD_MEAL_SUCCESS_CODE), 'success', self::RECORD_MEAL_SUCCESS_CODE, self::RECORD_MEAL_SUCCESS_MESSAGE, $data);
            exit();
        } catch (Exception $e) {
            $statusCode = $e->getCode() === 0 ? DEFAULT_ERROR_CODE : $e->getCode();
            $message = $e->getCode() === 0 ? DEFAULT_ERROR_MESSAGE : $e->getMessage();
            $this->setOutput($this->setHttpCode($statusCode), 'error', $statusCode, $message);
            exit();
        }
    }

    /**
     * set response
     *
     * @param int $httpCode http狀態碼
     * @param string $status 失敗/成功
     * @param string $statusCode 訊息碼
     * @param string $message 訊息內容
     * @param string $data 資料輸出
     * @return void
     */
    private function setOutput(int $httpCode, string $status, string $statusCode, string $message, array $data = array())
    {
        $jsonData = array(
            'status' => $status,
            'code' => $statusCode,
            'message' => $message,
            'csrfToken' => $this->security->get_csrf_hash()
        );
        if (!empty($data)) {
            $jsonData['data'] = $data;
        }
        $this->output
            ->set_status_header($httpCode)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($jsonData))
            ->_display();
    }

    /**
     * 刪除飲食紀錄
     * 
     * @return void 
     */
    public function deleteMeal()
    {
        try {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('mealId', 'Meal ID', 'required|integer|greater_than[0]');
            if ($this->form_validation->run() == FALSE) {
                throw new Exception(FORM_FORMAT_ERROR_MESSAGE, FORM_FORMAT_ERROR_CODE);
            }
            $this->load->model('DietModel');
            $result = $this->DietModel->deleteMeal($_POST['mealId']);
            if (!$result) {
                throw new Exception(DATABASE_ERROR_CODE, DATABASE_ERROR_MESSAGE);
            }
            // 輸出回應
            $this->setOutput($this->setHttpCode(self::RECORD_MEAL_SUCCESS_CODE), 'success', self::RECORD_MEAL_SUCCESS_CODE, self::RECORD_MEAL_SUCCESS_MESSAGE);
            exit();
        } catch (Exception $e) {
            $statusCode = $e->getCode() === 0 ? DEFAULT_ERROR_CODE : $e->getCode();
            $message = $e->getCode() === 0 ? DEFAULT_ERROR_MESSAGE : $e->getMessage();
            // $httpCode = $this->setHttpCode($statusCode);
            $this->setOutput($this->setHttpCode($statusCode), 'error', $statusCode, $message);
            exit();
        }
    }

    /**
     * 更新飲食紀錄
     */
    public function editMeal()
    {
        try {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('id', 'ID', 'required|integer|greater_than[0]');
            $this->form_validation->set_rules('food', 'Food', 'required|alpha');
            $this->form_validation->set_rules('calories', 'Calories', 'required|integer|greater_than[0]');
            if ($this->form_validation->run() == FALSE) {
                throw new Exception(FORM_FORMAT_ERROR_MESSAGE, FORM_FORMAT_ERROR_CODE);
            }
            $this->load->model('DietModel');
            $result = $this->DietModel->editMeal($_POST);
            if (!$result) {
                throw new Exception(DATABASE_ERROR_CODE, DATABASE_ERROR_MESSAGE);
            }
            // 輸出回應
            $this->setOutput($this->setHttpCode(self::RECORD_MEAL_SUCCESS_CODE), 'success', self::RECORD_MEAL_SUCCESS_CODE, self::RECORD_MEAL_SUCCESS_MESSAGE);
            exit();
        } catch (Exception $e) {
            $statusCode = $e->getCode() === 0 ? DEFAULT_ERROR_CODE : $e->getCode();
            $message = $e->getCode() === 0 ? DEFAULT_ERROR_MESSAGE : $e->getMessage();
            // $httpCode = $this->setHttpCode($statusCode);
            $this->setOutput($this->setHttpCode($statusCode), 'error', $statusCode, $message);
            exit();
        }
    }

    /**
     * 獲取飲食紀錄
     *
     * @param int $memberId 會員ID
     * @return array 飲食紀錄數據
     */
    private function getDietRecord(int $memberId): array
    {
        $this->load->model('DietModel');
        return $this->DietModel->getDietRecords($memberId);
    }

    /**
     * 獲取TDEE
     *
     * @param int $memberId 會員ID
     * @return int TDEE值
     */
    private function getTdee(int $memberId): int
    {
        $this->load->model('ProfileModel');
        return $this->ProfileModel->getTdee($memberId);
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
}
