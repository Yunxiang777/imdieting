<div class="container calorieLookup-view">
    <div class="card mb-3 calorieLookup-card">
        <div class="row g-0">
            <div class="col-lg-6 ">
                <div class="card-body calorieLookup-card-body">
                    <h1 class="card-title">Calorie Lookup</h1>
                    <p>Provide users with a convenient way to retrieve calorie
                        information . This feature can be utilized for
                        nutritional control, health management, or weight loss plans.</p>
                    <form class="row g-2">
                        <div class="col-12 calorieLookup-col">
                            <input type="text" class="form-control calorieLookup-foodName" id="calorieLookup-foodName" placeholder="Enter your food">
                            <button type="button" class="btn btn-outline-info calorieLookup-search" id="calorieLookup-search">Search</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-6 ">
                <img src="<?= base_url() . 'assets/img/breakfast.png' ?>" class="img-fluid rounded-start calorieLookup-img" alt="calorieLookup">
            </div>
        </div>
    </div>
</div>