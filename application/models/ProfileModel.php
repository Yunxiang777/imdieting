<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * ProfileModel 會員資料
 * 
 */
class ProfileModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * 取得會員圖片
     *
     * @param int $memberId 會員id
     * @return string
     */
    public function getProfileImg(int $memberId): string
    {
        $this->db->select('img')
            ->where('members_id', $memberId)
            ->from('profile');
        $result = $this->db->get()->row_array();
        return $result['img'] ? $result['img'] : '';
    }

    /**
     * 取得特定會員的 TDEE（每日總能量消耗）
     * 
     * @param int $memberId - 會員 ID
     * @return string - TDEE
     */
    public function getTdee(int $memberId): string
    {
        $this->db->select('tdee')
            ->from('profile')
            ->where('members_id', $memberId);
        $result = $this->db->get()->row_array();
        return $result['tdee'] ?? '';
    }

    /**
     * 提取會員資料
     *
     * @param int $memberId 會員ID
     * @return array 
     */
    public function getProfileData(int $memberId): array
    {
        $this->db->select('p.*, m.email')
            ->from('profile AS p')
            ->join('members AS m', 'p.members_id = m.id', 'left')
            ->where('p.members_id', $memberId);
        return $this->db->get()->row_array() ?: array();
    }

    /**
     * 更新會員資料
     *
     * @param int $memberId 會員ID
     * @param array $profileData 要更新的個人檔案資料
     * @return bool
     */
    public function updateProfileData(int $memberId, array $profileData): bool
    {
        try {
            $this->db->trans_start();
            $this->db->where('id', $memberId)
                ->update('members', ['email' => $profileData['email']]);
            unset($profileData['email']);
            $this->db->where('members_id', $memberId)
                ->update('profile', $profileData);
            $this->db->trans_complete();
            return $this->db->trans_status();
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', 'Error updating member data: ' . $e->getMessage());
            return false;
        }
    }
}
