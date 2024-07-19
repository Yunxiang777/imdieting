<div class="container bmr-view">
    <div class="card bmr-card">
        <div class="row g-0">
            <div class="col-lg-8 order-last order-lg-first">
                <img src="<?= base_url() . 'assets/img/bmr.png' ?>" class="img-fluid rounded-start bmr-img" alt="bmr">
            </div>
            <div class="col-lg-4 order-first order-lg-last">
                <div class="card-body">
                    <h1 class="card-title">BMR</h1>
                    <p>You burn calories even when resting through basic life-sustaining functions like breathing,
                        circulation, nutrient processing, and cell production.</p>
                    <p class="card-text"><small class="text-body-secondary">Counting your BMR</small></p>
                    <form class="row g-2">
                        <div class="col-md-6">
                            <label for="age" class="form-label">Age</label>
                            <input type="text" class="form-control" id="bmr-age" placeholder="Enter your age (numeric)">
                        </div>
                        <div class="col-md-6">
                            <label for="gender" class="form-label">Gender</label>
                            <select id="bmr-gender" class="form-select">
                                <option selected>male</option>
                                <option>female</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="height" class="form-label">Height</label>
                            <input type="text" class="form-control" id="bmr-height" placeholder="Enter your height (numeric)">
                        </div>
                        <div class="col-12">
                            <label for="weight" class="form-label">Weight</label>
                            <input type="text" class="form-control" id="bmr-weight" placeholder="Enter your weight (numeric)">
                        </div>

                        <div class="col-12 bmr-col">
                            <button type="button" class="btn btn-outline-success" id="bmr-countBmr">COUNT</button>
                        </div>
                        <div class="col-12 bmr-col">
                            <p id="bmr-bmrResult">Basal metabolic rate (BMR) calculation: </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>