<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * DietModel 飲食紀錄
 * 
 */
class DietModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * 寫入飲食紀錄
     * 
     * @param array $data 飲食紀錄資訊
     * @return string 新插入資料ID 或者 空字串
     */
    public function addMeal(array $data): string
    {
        $this->db->insert('diet_records', $data);
        return $this->db->insert_id();
    }

    /**
     * 根據會員ID取出今日飲食紀錄
     * 
     * @param int $memberId 會員ID
     * @return array 飲食紀錄數組或空數組
     */
    public function getDietRecords(int $memberId): array
    {
        $this->db->select('id, food, calories, date')
            ->from('diet_records')
            ->where('member_id', $memberId)
            ->where('date', date('Y-m-d'));
        return $this->db->get()->result_array();
    }

    /**
     * 刪除指定飲食紀錄
     * 
     * @param int $mealId 飲食紀錄ID
     * @return bool
     */
    public function deleteMeal(int $mealId): bool
    {
        $this->db->where('id', $mealId)
            ->delete('diet_records');
        return $this->db->affected_rows() > 0;
    }

    /**
     * 更新紀錄
     * 
     * @param array $meal 紀錄數據
     * @return bool
     */
    public function editMeal(array $meal): bool
    {
        $this->db->where('id', $meal['id']);
        unset($meal['id']);
        $this->db->update('diet_records', $meal);
        return $this->db->affected_rows() > 0;
    }
}
