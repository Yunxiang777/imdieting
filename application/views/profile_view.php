<?php
$img = htmlspecialchars($profileData['img']);
$email = htmlspecialchars($profileData['email']);
$phone = htmlspecialchars($profileData['phone']);
$work = htmlspecialchars($profileData['work']);
$gender = htmlspecialchars($profileData['gender']);
$age = htmlspecialchars($profileData['age']);
$age = $age  === '0' ? '' : $age;
$height = htmlspecialchars($profileData['height']);
$height = $height  === '0' ? '' : $height;
$weight = htmlspecialchars($profileData['weight']);
$weight = $weight  === '0.00' ? '' : $weight;
?>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/profileSetting.css?v=' . time()) ?>">
<div class="container mt-5 mb-5 profileSetting-view">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-header" style="padding:5%;">
                    <img src="<?= $img ?>" alt="avatar" class="img-fluid"
                        onerror="this.onerror=null; this.src='<?= base_url('assets/img/default.png') ?>';"
                        style="width: 100%;" id="profileSetting-avatarImg">
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <label for="profileSetting-email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="profileSetting-email" value="<?= $email ?>"
                            readonly>
                    </div>
                    <div class="mb-3">
                        <label for="profileSetting-phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="profileSetting-phone" value="<?= $phone ?>"
                            placeholder="please enter a valid phone number format.">
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-6 profileSetting-work"><label for="profileSetting-work"
                                class="form-label">Work</label>
                            <select id="profileSetting-work" class="form-select">
                                <option <?= $work === 'low' ? 'selected' : ''; ?> value="low">Low
                                    intensit
                                </option>
                                <option <?= $work === 'medium' ? 'selected' : ''; ?> value="medium">
                                    Medium intensity
                                </option>
                                <option <?= $work === 'high' ? 'selected' : ''; ?> value="high">High
                                    strength
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6"><label for="profileSetting-gender" class="form-label">Gender</label>
                            <select id="profileSetting-gender" class="form-select">
                                <option <?= $gender === 'male' ? 'selected' : ''; ?>>
                                    male</option>
                                <option <?= $gender === 'female' ? 'selected' : ''; ?>>
                                    female</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="profileSetting-age" class="form-label">Age</label>
                        <input type="text" class="form-control" id="profileSetting-age" value="<?= $age ?>"
                            placeholder="positive integer no more than three digits.">
                    </div>
                    <div class="mb-3">
                        <label for="profileSetting-height" class="form-label">Height</label>
                        <input type="text" class="form-control" id="profileSetting-height" value="<?= $height ?>"
                            placeholder="positive integer no more than three digits.">
                    </div>
                    <div class="mb-3">
                        <label for="profileSetting-weight" class="form-label">weight</label>
                        <input type="text" class="form-control" id="profileSetting-weight" value="<?= $weight ?>"
                            placeholder="No more than three digits and up to two decimal places.">
                    </div>
                    <div class="mt-4 mb-2">
                        <button type="button" class="btn btn-outline-primary" id="profileSetting-confirm"
                            style="width: 100%;">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for image cropping -->
    <?php $this->load->view('template/modalImageCrop', ['view' => 'profileSetting']); ?>
</div>
<script src="<?= base_url('assets/js/member/profileSetting.js?v=' . time()) ?>"></script>