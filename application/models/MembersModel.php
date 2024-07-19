<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * MembersModel 使用者與會員資料操作
 * 
 */
class MembersModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database(); // 載入資料庫類別
    }

    /**
     * 會員註冊
     *
     * @param array $userData  會員註冊mail與密碼
     * @return bool
     */
    public function signUp(array $userData): bool
    {
        $this->db->trans_start();
        $this->db->insert('members', $userData);
        $this->db->insert('profile', array('members_id' => $this->db->insert_id()));
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    /**
     * 會員登入
     *
     * @param string $email 會員登入的mail
     * @return array 使用者資料
     */
    public function auth(string $email): array
    {
        $this->db->select('*')
            ->where('email', $email)
            ->from('members');
        return $this->db->get()->row_array() ?: array();
    }

    /**
     * 確認email是否已存在
     *
     * @param string $email
     * @return bool
     */
    public function checkEmailExisted(string $email): bool
    {
        $this->db->select('1')
            ->where('email', $email)
            ->from('members');
        return $this->db->get()->num_rows() > 0;
    }
}
