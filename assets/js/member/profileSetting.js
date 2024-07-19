/* profileSetting View JS */
$(document).ready(function () {
    var inputvalidator = new InputValidator();
    var callapi = new CallApi();
    var imagetypedetector = new ImageTypeDetector();
    var customizecropper = new CustomizeCropper('.profileSetting-view', '#profileSetting-avatarImg', 'profileSetting', '#profileSetting-avatarImg');
    customizecropper.useRectangle(490, 420);
    var bodydata = new BodyData();

    // confirm觸發
    $('.profileSetting-view').on('click', '#profileSetting-confirm', function () {
        //表單驗證
        var fieldsToValidate = [
            { id: 'profileSetting-email', validator: inputvalidator.isValidEmail, target: 'email' },
            { id: 'profileSetting-phone', validator: inputvalidator.validatePhoneNumber, target: 'phone' },
            { id: 'profileSetting-age', validator: inputvalidator.validatePositiveInteger, target: 'age' },
            { id: 'profileSetting-height', validator: inputvalidator.validatePositiveInteger, target: 'height' },
            { id: 'profileSetting-weight', validator: inputvalidator.validateNumberWithDecimals, target: 'weight' }
        ];
        var fieldValues = {}; //表單value對象
        for (var i = 0; i < fieldsToValidate.length; i++) {
            var field = fieldsToValidate[i];
            var value = $("#" + field.id).val();
            fieldValues[field.target] = value;
            if (!field.validator(value)) {
                inputvalidator.displayError(field.id, field.target);
                return;
            }
        }
        fieldValues['img'] = imagetypedetector.setImage($("#profileSetting-avatarImg").attr('src'));
        fieldValues['gender'] = $("#profileSetting-gender").val();
        fieldValues['work'] = $("#profileSetting-work").val();
        fieldValues['tdee'] = bodydata.calculateTdee(fieldValues['age'], fieldValues['gender'], fieldValues['height'], fieldValues['weight'], fieldValues['work']);
        //call Api
        callapi.checkApiResult(API_URLS.UPDATE_PROFILE, fieldValues, 'Updating Profile', 'Update Successful', 'Your profile has been successfully updated.', 'Update Failed', 'Failed to update your profile. Please try again later.', false, '');
    })
    inputvalidator.resetError('#profileSetting-email, #profileSetting-phone, #profileSetting-age,#profileSetting-height, #profileSetting-weight');
})