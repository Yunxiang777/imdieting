<script>
const BASE_URL = " <?= base_url() ?>";
const API_URLS = {
    LOGIN: BASE_URL + 'v1/members/auth',
    SIGN_UP: BASE_URL + 'v1/members/signUp',
    GET_FOOD_DATA: BASE_URL + 'v1/diet/getFoodData',
    GET_MEAL_DATA: BASE_URL + 'v1/diet/getMealData',
    ADD_MEAL: BASE_URL + 'v1/diet/addMeal',
    DELETE_MEAL: BASE_URL + 'v1/diet/deleteMeal',
    EDIT_MEAL: BASE_URL + 'v1/diet/editMeal',
    UPDATE_PROFILE: BASE_URL + 'v1/profile/update',
    GET_ARTICLE: BASE_URL + 'v1/article/getArticle'
};
</script>