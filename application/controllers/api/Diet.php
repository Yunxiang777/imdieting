<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Diet 飲食相關api
 * 
 */
class Diet extends CI_Controller
{
    const GET_FOOD_DATA_SUCCESS_CODE = '0000';
    const GET_FOOD_DATA_SUCCESS_MESSAGE = 'Get Food Data Successful';
    const GET_MEAL_DATA_SUCCESS_CODE = '0000';
    const GET_MEAL_DATA_SUCCESS_MESSAGE = 'Get Meal Data Successful';
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 查詢食物數據api
     *
     * @return void - 直接輸出 JSON 回應
     */
    public function getFoodData()
    {
        try {
            // 格式過濾
            $foodName = isset($_POST['foodName']) ? htmlspecialchars($_POST['foodName'], ENT_QUOTES, 'UTF-8') : '';
            if (!$foodName) {
                throw new Exception(FORM_FORMAT_ERROR_MESSAGE, FORM_FORMAT_ERROR_CODE);
            }
            // api組成
            $apiUrl = $this->formatApiUrlSingleFood($foodName);
            $data = json_decode(file_get_contents($apiUrl), true);
            $data = isset($data['hints']['0']['food']['nutrients']) ? $data['hints']['0']['food']['nutrients'] : array();
            // 回應
            $this->setOutput($this->setHttpCode(self::GET_FOOD_DATA_SUCCESS_CODE), 'success', self::GET_FOOD_DATA_SUCCESS_CODE, self::GET_FOOD_DATA_SUCCESS_MESSAGE, $data);
            exit();
        } catch (Exception $e) {
            $statusCode = $e->getCode() === 0 ? DEFAULT_ERROR_CODE : $e->getCode();
            $message = $e->getCode() === 0 ? DEFAULT_ERROR_MESSAGE : $e->getMessage();
            $this->setOutput($this->setHttpCode($statusCode), 'error', $statusCode, $message);
            exit();
        }
    }

    /**
     * 查詢菜單數據
     *
     * @return array - JSON 回應
     */
    public function getMealData()
    {
        try {
            // 格式過濾
            $meals = isset($_POST['meals']) ? json_decode($_POST['meals']) : array();
            if (empty($meals)) {
                throw new Exception(FORM_FORMAT_ERROR_MESSAGE, FORM_FORMAT_ERROR_CODE);
            }
            // 請求資料
            $results = array();
            foreach ($meals as $meal) {
                $apiUrl = $this->formatApiUrlMeal($meal);
                $curl = curl_init($apiUrl);
                curl_setopt_array($curl, array(
                    CURLOPT_RETURNTRANSFER => TRUE,
                    CURLOPT_HTTPHEADER => array('Accept: application/json'),
                ));
                $response = curl_exec($curl);
                curl_close($curl);
                $meal = json_decode($response, true);
                if (curl_errno($curl) || empty($meal['dietLabels'])) {
                    throw new Exception(FORM_FORMAT_ERROR_MESSAGE, FORM_FORMAT_ERROR_CODE);
                }
                $results[] = array_map(function ($item) {
                    return $item['quantity'];
                }, array_slice($meal['totalNutrients'], 0, 5, true));
            }
            // 計算總熱量
            $summedResults = $this->sumMeals($results);
            // 回應
            $this->setOutput($this->setHttpCode(self::GET_MEAL_DATA_SUCCESS_CODE), 'success', self::GET_MEAL_DATA_SUCCESS_CODE, self::GET_MEAL_DATA_SUCCESS_MESSAGE, $summedResults);
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
     * 計算菜單總熱量
     *
     * @param array $meal 依訊息狀態碼
     * @return array
     */
    private function sumMeals(array $meals): array
    {
        return array_reduce($meals, function ($carry, $meal) {
            foreach ($meal as $key => $value) {
                $carry[$key] = ($carry[$key] ?? 0) + $value;
            }
            return $carry;
        }, array());
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
     * 格式化食物查詢數據api
     *
     * @param string $foodName 食物名稱
     * @return string apiUrl
     */
    private function formatApiUrlSingleFood(string $foodName): string
    {
        return FOOD_API . '?app_id=' . FOOD_DATABASE_APP_ID . '&app_key=' . FOOD_DATABASE_APP_KEY . '&ingr=' . $foodName . '&nutrition-type=cooking';
    }

    /**
     * 格式化菜單查詢數據api
     *
     * @param string $meal 菜單
     * @return string apiUrl
     */
    private function formatApiUrlMeal(string $meal): string
    {
        return MEAL_API . '?app_id=' . MEAL_DATABASE_APP_ID . '&app_key=' . MEAL_DATABASE_APP_KEY . '&ingr=' . urlencode($meal) . '&nutrition-type=cooking';
    }
}
