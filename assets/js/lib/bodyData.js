/**
 * 用戶身體數據資料計算與分析
 * 
 */
class BodyData {

    /**
    * BMR計算器
    * 
    * @param {int} age - 年齡
    * @param {string} gender - 性別
    * @param {floate} height - 身高(cm)
    * @param {floate} weight - 體重(kg)
    * @return {floate} - bmr結果
    */
    calculateBMR(age, gender, height, weight) {
        var factor = (gender === 'male') ? 5 : -161;
        return 10 * parseFloat(weight) + 6.25 * parseFloat(height) - 5 * parseFloat(age) + factor;
    }

    /**
    * TDEE計算器
    * 
    * @param {int} age - 年齡
    * @param {string} gender - 性別
    * @param {floate} height - 身高(cm)
    * @param {floate} weight - 體重(kg)
    * @return {floate} - tdee結果
    */
    calculateTdee(age, gender, height, weight, work) {
        return this.calculateBMR(age, gender, height, weight) + (work === 'low' ? 200 : (work === 'medium' ? 400 : (work === 'high' ? 600 : 0)));
    }
}