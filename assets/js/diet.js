/* diet View JS */

/* diet-view-leftContent */
$(document).ready(function () {
    var sweatalert = new SweatAlert();
    var inputvalidator = new InputValidator();
    var addMeal = `<button class="btn btn-outline-danger diet-view-addMeal" type="button" id="diet-view-addMeal">Add Meal</button>`;
    var searchDataElement = $('[data="diet-view-SearchData"]');
    var dietDropDown = $('#diet-view-dropDown');
    var csrfHash = $('#csrfHash');

    /**
     * 取得用戶端錯誤訊息
     * 
     * @param {string} errorCode - 錯誤碼
     * @return {string} - 錯誤訊息內容
     */
    function getErrorMessage(errorCode) {
        let errorMessage = '';
        switch (String(errorCode)) {
            case '1003':
                errorMessage = 'invalid format';
                break;
            default:
                errorMessage = 'invalid format';
                break;
        }
        return errorMessage;
    }

    /**
     * 食物與菜單搜尋
     */
    $("#diet-view-leftContent").on("click", ".diet-view-dropdown-item", function (event) {
        event.preventDefault();
        var liText = $(this).text();
        $("#diet-view-foodInput").attr("placeholder", liText);
        $("#diet-view-animateText").text(`Searching ${liText} results here...`);
        var isMenu = liText === 'Menu Analysis';
        var lesswidth = $(window).width() < 600;
        if (isMenu) {
            $(addMeal).insertBefore('#diet-view-searchFood');
            $('#diet-view-addMeal').toggleClass('width33', lesswidth);

        } else {
            $('#diet-view-addMeal').remove();
            $('.diet-view-mealCard').empty();
        }
        searchDataElement.add(dietDropDown).removeClass(isMenu ? 'width50' : 'width33').toggleClass(isMenu ? 'width33' : 'width50', lesswidth);
        searchDataElement.attr("id", isMenu ? "diet-view-searchMenu" : "diet-view-searchFood");
    });

    /**
     * 獲取食物營養資料
     */
    $("#diet-view-leftContent").on("click", "#diet-view-searchFood", () => {
        var food = $("#diet-view-foodInput").val();
        if (!inputvalidator.validateText(food)) {
            inputvalidator.displayError('diet-view-foodInput', '', 'Not valid!');
            return;
        }
        var formData = new FormData();
        formData.append('foodName', food);
        formData.append(csrfName, csrfHash.text());
        if (food) {
            axios.post(API_URLS.GET_FOOD_DATA, formData)
                .then((res) => {
                    responseFoodData(res, 'Food');
                })
                .catch(function (error) {
                    csrfHash.text(error.response.data.csrfToken);
                    sweatalert.showNotification("Oops...", getErrorMessage(error.response.data.code), false, 1500);
                });
        }
    });

    /**
     * 獲取菜單營養資料
     */
    $("#diet-view-leftContent").on("click", "#diet-view-searchMenu", () => {
        var meals = [];
        $("#diet-view .diet-view-addMealCard").each((index, element) => {
            meals.push($(element).text());
        });
        if (meals.length === 0) {
            inputvalidator.displayError('diet-view-foodInput', '', 'Not valid!');
            return;
        }
        var formData = new FormData();
        formData.append('meals', JSON.stringify(meals));
        formData.append(csrfName, csrfHash.text());
        axios.post(API_URLS.GET_MEAL_DATA, formData)
            .then((res) => {
                responseFoodData(res, 'Menu');
            })
            .catch(function (error) {
                csrfHash.text(error.response.data.csrfToken);
                sweatalert.showNotification("Oops...", getErrorMessage(error.response.data.code), false, 1500);
            });
    });

    /**
     * 新增菜單
     */
    $("#diet-view-leftContent").on("click", "#diet-view-addMeal", () => {
        var meal = $('#diet-view-foodInput').val();
        if (!meal) {
            inputvalidator.displayError('diet-view-foodInput', '', 'Not valid!');
            return;
        }
        var mealCard = `<div class='diet-view-addMealCard'>${meal}<i class="fa-solid fa-delete-left fa-lg"></i></div>`;
        $(".diet-view-mealCard").html($(".diet-view-mealCard").html() + mealCard);

    })

    /**
     * 刪除菜單
     */
    $("#diet-view-leftContent").on("click", ".fa-delete-left", (e) => {
        $(e.target).closest('.diet-view-addMealCard').remove();
    })

    /**
     * 菜單食譜模板
     * @param {object} res - 包含食譜數據的響應對象
     * @param {string} view - 視圖名稱
     */
    var responseFoodData = (res, view) => {
        var foods = res.data.data;
        csrfHash.text(res.data.csrfToken);
        if (foods) {
            var content = '<table class="table table-bordered" style="margin-bottom: 0;"> <tbody>';
            Object.keys(foods).forEach(function (key, index) {
                content += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${key}</td>
                    <td>${parseFloat(foods[key]).toFixed(1)}</td>
                </tr>
            `;
            });
            content += '</tbody></table>';
        } else {
            var content = "Couldn't find the corresponding " + view;
        }
        $("#diet-view-animateText").html(content);
    }

    //重置錯誤
    inputvalidator.resetError('#diet-view-foodInput');
    /**
     * RWD
     */
    var resizeElement = () => {
        var addMealExist = $('#diet-view-addMeal').length > 0;
        if ($(window).width() < 600) {
            $('#diet-view-foodInput').prependTo('.diet-view-searchFood');
            searchDataElement.toggleClass('width33', addMealExist).toggleClass('width50', !addMealExist);
            dietDropDown.toggleClass('width33', addMealExist).toggleClass('width50', !addMealExist);
            addMealExist ? $('#diet-view-addMeal').addClass('width33') : null;
        } else {
            $('#diet-view-foodInput').prependTo('.diet-view-foodBox');
            searchDataElement.add('#diet-view-dropDown, #diet-view-addMeal').removeClass('width50 width33');
        }
    }
    resizeElement();
    $(window).resize(() => {
        resizeElement();
    });
});

/* diet-view-rightContent */
$(document).ready(function () {
    var inputvalidator = new InputValidator();
    var sweatalert = new SweatAlert();
    var tdeeValue = $('#diet-view-rightContent-tdeeNum').text().replace('TDEE ', '');
    var csrfHash = $('#csrfHash');

    /**
     * 取得用戶端錯誤訊息
     * 
     * @param {string} errorCode - 錯誤碼
     * @return {string} - 錯誤訊息內容
     */
    function getErrorMessage(errorCode) {
        let errorMessage = '';
        switch (errorCode) {
            case '1003':
                errorMessage = 'invalid format';
                break;
            default:
                errorMessage = 'invalid format';
                break;
        }
        return errorMessage;
    }
    /**
     * 紀錄食物
     */
    $("#diet-view-rightContent").on("click", "#diet-view-rightContent-recordMeal", () => {
        var food = $("#diet-view-rightContent-recordFood").val();
        var calories = $("#diet-view-rightContent-recordCalories").val();
        if (!inputvalidator.validateText(food)) {
            inputvalidator.displayError('diet-view-rightContent-recordFood', '', 'Not valid!');
            return;
        }
        if (!inputvalidator.validateNatural(calories)) {
            inputvalidator.displayError('diet-view-rightContent-recordCalories', '', 'Not valid!');
            return;
        }
        var formData = new FormData();
        formData.append('food', food);
        formData.append('calories', calories);
        formData.append(csrfName, csrfHash.text());
        axios.post(API_URLS.ADD_MEAL, formData)
            .then((res) => {
                var result = res.data.data;
                csrfHash.text(res.data.csrfToken);
                if (result) {
                    var content = `
                    <tr>
                        <th scope="row">${result.mealId}</th>
                        <td>${food}</td>
                        <td class="diet-view-rightContent-tdCalories">${calories}</td>
                        <td>${result.date}</td>
                        <td class="diet-view-rightContent-icon">
                            <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus"
                                data-bs-content="Delete">
                                <i class="fa-solid fa-trash"></i>
                            </span>
                            <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus"
                                data-bs-content="Edit">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </span>
                        </td>
                    </tr>`;
                    $('#diet-view-rightContent-table').append(content);
                }
                //計算TDEE
                dealTdee();
                setPopover();
            })
            .catch(function (error) {
                csrfHash.text(error.response.data.csrfToken);
                sweatalert.showNotification("Oops...", getErrorMessage(error.response.data.code), false, 1500);
            });
    });

    /**
     * 刪除紀錄
     */
    $("#diet-view-rightContent").on("click", ".fa-trash", (event) => {
        var $row = $(event.target).closest('tr');
        var formData = new FormData();
        formData.append('mealId', $row.find('th').text());
        formData.append(csrfName, csrfHash.text());
        axios.post(API_URLS.DELETE_MEAL, formData)
            .then((res) => {
                csrfHash.text(res.data.csrfToken);
                $row.remove();
                dealTdee();
            })
            .catch(function (error) {
                csrfHash.text(error.response.data.csrfToken);
                sweatalert.showNotification("Oops...", getErrorMessage(error.response.data.code), false, 1500);
            });
    })

    /**
     * 編輯紀錄
     */
    $("#diet-view-rightContent").on("click", ".fa-regular", (event) => {
        var row = $(event.target).closest('tr');
        var food = row.find('td:eq(0)');
        var calories = row.find('td:eq(1)');
        editMeal(food.text(), calories.text()).then(result => {
            if (result.isConfirmed) {
                callUpdateMealApi(food, calories, row.find('th').text(), result.value);
            }
        }).catch(error => {
            csrfHash.text(error.response.data.csrfToken);
            sweatalert.showNotification("Oops...", getErrorMessage(error.response.data.code), false, 1500);
        });
    });

    /**
     * 更新食物 API
     * 
     * @param {Object} food 食物元素
     * @param {Object} calories 卡路里元素
     * @param {string} id 食物ID
     * @param {Object} result 更新的结果
     */
    var callUpdateMealApi = (food, calories, id, result) => {
        var formData = new FormData();
        formData.append('id', id);
        formData.append('food', result.food);
        formData.append('calories', result.calories);
        formData.append(csrfName, csrfHash.text());
        axios.post(API_URLS.EDIT_MEAL, formData)
            .then((res) => {
                csrfHash.text(res.data.csrfToken);
                food.text(result.food);
                calories.text(result.calories);
                //計算TDEE
                dealTdee();
            })
            .catch(function (error) {
                csrfHash.text(error.response.data.csrfToken);
                sweatalert.showNotification("Oops...", getErrorMessage(error.response.data.code), false, 1500);
            });
    }

    /**
     * 修改菜單
     * @param {string} food 食物名稱
     * @param {string} calories 卡路里
     * @returns {Promise} 
     */
    var editMeal = (food, calories) => {
        return new Promise((resolve, reject) => {
            Swal.fire({
                title: 'Edit Meal',
                html: `
                <input id="alert-food" class="swal2-input" placeholder="food" value="${food}">
                <input id="alert-calories" class="swal2-input" placeholder="calories" value="${calories}">
                `,
                focusConfirm: false,
                preConfirm: () => {
                    var food = $('#alert-food').val();
                    var calories = $('#alert-calories').val();
                    if (!food || !calories) {
                        Swal.showValidationMessage('Food name and Calories cannot be empty');
                    }
                    return { food: food, calories: calories };
                },
                confirmButtonText: 'Save Change'
            }).then((result) => {
                result.isConfirmed ? resolve(result) : reject(false);
            });
        });
    };

    /**
     * 計算TDEE
     */
    var dealTdee = () => {
        let totalCalories = 0;
        $('.diet-view-rightContent-tdCalories').each((index, element) => {
            let calories = parseFloat($(element).text());
            if (!isNaN(calories)) {
                totalCalories += calories;
            }
        });
        var tdeePercent = Math.round(totalCalories / tdeeValue * 100);
        tdeePercent = tdeePercent > 100 ? '100%' : tdeePercent + '%';
        $('.diet-view-rightContent-progress').css('width', tdeePercent).text(tdeePercent);
    }

    /* 
     *漂浮字效果 
     */
    var setPopover = () => {
        $('[data-bs-toggle="popover"]').each(function () {
            $(this).popover();
        });
    }
    //TDEE計算初始化
    dealTdee();
    //漂浮字初始化
    setPopover();
    //錯誤重置
    inputvalidator.resetError('#diet-view-rightContent-recordFood,#diet-view-rightContent-recordCalories');
})

/* 漂浮字效果 */
$(document).ready(function () {
    $('#diet-view-rightContent').on('click', '[data-bs-toggle="popover"]', () => {
        $('.popover ').remove();
    });
});