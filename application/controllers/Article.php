<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Article 文章資訊頁面
 */
class Article extends CI_Controller
{

    /**
     * 主頁面
     *
     */
    public function main()
    {
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $this->session->set_userdata('articleDate', $yesterday);
        $data['articles'] = $this->getNews($yesterday);
        $this->load->view('layouts/layout', [
            'title' => 'Article',
            'content' => $this->load->view('article_view', $data, TRUE),
            'page' => 'article'
        ]);
    }

    /**
     * 瀑布流獲取文章資訊
     *
     */
    public function getWaterfallData()
    {
        $date = date('Y-m-d', strtotime($this->session->userdata('articleDate') . ' -1 day'));
        $this->session->set_userdata('articleDate', $date);
        $news = $this->getNews($date);
        $httpCode = !empty($news) ? 200 : 500;
        // 輸出回應
        $this->output
            ->set_status_header($httpCode)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode(array('data' => $news, 'csrfToken' => $this->security->get_csrf_hash())))
            ->_display();
        exit();
    }

    /**
     * 獲取文章資訊
     *
     * @param string $date 指定的日期
     * @return array 包含文章資訊的數組
     */
    private function getNews(string $date): array
    {
        $queryParams = [
            'q' => 'food',
            'from' => $date . 'T00:00:00Z',
            'to' => $date . 'T23:59:59Z',
            'sortBy' => 'popularity',
            'apikey' => NEWS_NEWS_APP_KEY,
            'max' => 30 // 取前30則
        ];
        $curl = curl_init(NEWS_API . '?' . http_build_query($queryParams));
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_USERAGENT => 'imdieting',
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response ? json_decode($response, true)['articles'] : array();
    }
}
