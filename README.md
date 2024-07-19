# Imdieting
##### 這是一個熱量控制，飲食配置的瘦身網站，配合正在健身與有氧的你/妳。
---
## 功能介紹
1. BMR/TDEE，個人每日消耗卡路里評估。
2. 食物熱量預估/組合餐點總熱量評估。
3. 食物拍照記錄。
4. 全球國際，最新飲食健康紀錄新聞。
5. 每日熱量消耗紀錄。
## 安裝配置
1. 作業系統 : 開發-WIN10(wxampp) / 測試-CentOS9(httpd)
2. DATABASE : 開發-MYsql / 測試-MYsql
## 使用技術
1. 語言 : PHP，JS
2. 框架 : codeigniter3，jquery，bootstrap5
3. 資料庫 : MYsql
4. 技術 : MVC，AJAX，HTTP，RESTFUL API，FTP，JSON，SESSION，COOKIE，RWD，CURL
5. 版本控制 : GIT，GITHUB
## 開發
1. 全域
   - 樣式使用CSS框架bootstrap5，sweatAlert2
   - JQUERY做前端VIEW開發
   - 後端搭配PHP，SQL
2. 會員系統
   - 會員密碼bcrypt不可逆加密
   - session後端使用者驗證
   - 前端cookie記住我功能
3. 個人資料頁
   - 資料庫CRUD
   - 圖片處裡 : 使用 'Cropper.js'CDN，前端圖片裁減功能，達到上傳客製化圖片頭像功能
   - 圖像保存 : 為保存專案的容量與網頁載入效率，選擇只在資料庫保存圖片路徑，減少資料庫消耗。
   - 圖像web存儲 : search => 自定義image_helper.php文件
   ###### image_helper.php :
   - [imgur](https://imgur.com/)，免費WEB HOST儲存圖像數據
   - cropper裁減圖片 -> Base64圖像編碼 -> ajax call imgurApi儲存圖像 -> 圖像儲存webHost並res圖片路徑 -> AJAX修改頁面圖像 -> 資料庫儲存圖片路徑
   - 達成減少資料庫負荷，縮小專案網路負荷效率
4. 首頁
   - layout : 布局共用元件，header/footer/CDN/自定義LIB
   - BMR : 計算基礎代謝率，前端使用者格式輸入判斷，錯誤處理，結果計算
   - Calorie Lookup : 食物熱量查詢，使用 [Edamam](https://www.edamam.com/) API，後端使用file_get_contents get返回值
   - Record Food : cropper裁切圖片，jquery處理生成圖片，置換頁面DOM元素
5. Diet
   - food/meal熱量查詢 : jquery動態生成dom元素，ajax res查詢結果，達到單個食物，組合食物營養查詢的功能
   - Diet Record : bootstrap搭配jquery動態修改value，達成TDEE熱量控制紀錄
6. Article
   - NewsApi : [News Api](https://newsapi.org/)
   - 後端使用PHP CURL請求API資源
   - view瀑布流 : 一次最多10筆新聞資料，偵測使用者瀏覽至頁底，才進行api請求，減少network負荷，加快頁面載入速度與效率
   - 前端 : article.js文件 => '瀑布流' => 偵測使用者頁面 => 滑到頁底 => 顯示loading圖(同時ajax請求api) => 後端curl請求返回資料 => 前端收到數據，移除loading，顯示新聞
7. 自定義js/Lib
   - 整理常用表單判斷，call api，cropper圖像裁切，ajax，sweatAlert
## 版本控制與資源管理
1. git/gitgub : 版本控制
2. FTP : 使用FileZilla軟體進行生產環境文件管理
