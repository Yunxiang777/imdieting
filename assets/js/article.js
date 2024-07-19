/* article View JS */
$(document).ready(function () {

    var csrfHash = $('#csrfHash');

    //瀑布流監控
    monitorWaterfallFlow();

    /**
     * 抓取瀑布流資料
     */
    function callApiForMoreData() {
        var config = { onUploadProgress: setLoadingElement(true) };
        var formData = new FormData();
        formData.append(csrfName, csrfHash.text());
        axios.post(API_URLS.GET_ARTICLE, formData, config)
            .then((res) => {
                csrfHash.text(res.data.csrfToken);
                setLoadingElement(false);
                //製作瀑布流元素
                creatDataElement(res.data.data);
                //重新監聽瀑布流
                monitorWaterfallFlow();
            })
            .catch((error) => {
                csrfHash.text(error.response.data.csrfToken);
            });
    }


    /**
     * 新增或移除loading元素
     * @param {boolean} set 
     */
    function setLoadingElement(set) {
        set ?
            $(".article-view-content").append(`
            <div id='loading' style="display: flex;justify-content: center; margin-bottom:15px;">
                <div class="spinner-grow text-secondary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>`)
            :
            $("#loading").remove();
    }

    /**
     * 監控是否到頁底
     */
    function monitorWaterfallFlow() {
        var isFirstCall = true;
        $(window).scroll(function () {
            if (($(window).scrollTop() + $(window).height() + 100) >= $(document).height()) {
                if (isFirstCall) {
                    callApiForMoreData();
                    isFirstCall = false;
                } else {
                    $(window).off('scroll');
                }
            }
        });
    }

    /**
    * 製作瀑布流元素並新增至頁底
    * @param {Array} res - api回傳值
    */
    function creatDataElement(res) {
        for (var i in res) {
            var item = res[i];
            if (!item.image) {
                continue;
            }
            var cardTemplate = `
                <div class="card mb-3 col-xl-12 col-md-6">
                    <div class="row g-0">
                        <div class="col-xl-4 col-md-12">
                            <img class="img-fluid rounded-start" src="${item.image}" alt="${item.title}" style="width:100%;max-height:300px;"
                            onerror="this.onerror=null; this.src='${BASE_URL}/assets/img/default.png';"
                            >
                        </div>
                        <div class="col-xl-8 co-md-12">
                            <div class="card-body">
                                <h5 class="card-title">${item.title}</h5>
                                <p class="card-text" id="card-text">${item.description}</p>
                                <p class="card-text"><small class="text-body-secondary">publishedAt : ${item.publishedAt}</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $(".article-view-content").append(cardTemplate);
        }
    }

})