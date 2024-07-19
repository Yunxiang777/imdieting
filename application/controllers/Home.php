<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Home 首頁前台
 * 
 */
class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 首頁視圖
     *
     */
    public function main()
    {
        $data['title'] = 'home';
        $data['content'] = $this->load->view('home/home_view', NULL, TRUE);
        $data['page'] = 'home';
        $this->load->view('layouts/layout', $data);
    }

    /**
     * 查詢食物數據api
     *
     * @return void - 直接輸出 JSON 回應
     */
    public function getFoodData()
    {
        $jsonData = json_decode($this->input->raw_input_stream, true);
        $apiUrl = "https://api.edamam.com/api/food-database/v2/parser?app_id=" .
            $this->config->item('foodDataBaseAppId')
            . "&app_key=" .
            $this->config->item('foodDataBaseAppKey')
            . "&ingr=" . $jsonData['foodName'] . "&nutrition-type=cooking";

        try {
            $data = json_decode(file_get_contents($apiUrl), true);
            $data = isset($data['hints']['0']['food']['nutrients']) ? $data['hints']['0']['food']['nutrients'] : false;
            echo json_encode(array('result' => $data));
        } catch (Exception $e) {
            log_message('error',  $e->getMessage());
            echo 'error,find corresponding food information.';
        }
    }
}