<div class="col-lg-6 diet-view-rightContent" id="diet-view-rightContent">
    <?php if ($tdee === 0) : ?>
        <h2>Diet Record </h2>
        <p>Complete the personal profile setup to use the diet record feature.</p>
        <a href="<?= base_url('profile') ?>">GO TO PROFILE SETTING</a>
    <?php else : ?>
        <h2>Diet Record <span class="badge  text-bg-secondary" id="diet-view-rightContent-tdeeNum">TDEE <?= $tdee ?></span>
        </h2>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="food name" aria-label="recordFood" aria-describedby="recordFood" id="diet-view-rightContent-recordFood">
            <input type="text" class="form-control" placeholder="calories" aria-label="recordCalories" aria-describedby="recordCalories" id="diet-view-rightContent-recordCalories">
            <button class="btn btn-outline-success" type="button" id="diet-view-rightContent-recordMeal">Record
                Meal</button>
        </div>
        <div class="progress mb-3" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
            <div class="progress-bar bg-success diet-view-rightContent-progress" style="width: 0%">0%</div>
        </div>
        <table class="table table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Food</th>
                    <th scope="col">Calories</th>
                    <th scope="col">Time</th>
                    <th scope="col">Edit</th>
                </tr>
            </thead>
            <tbody class="table-group-divider" id="diet-view-rightContent-table">
                <?php foreach ($dietRecord as $record) : ?>
                    <tr>
                        <th scope="row"><?= $record['id']; ?></th>
                        <td><?= $record['food']; ?></td>
                        <td class="diet-view-rightContent-tdCalories"><?= $record['calories']; ?></td>
                        <td><?= $record['date']; ?></td>
                        <td class="diet-view-rightContent-icon">
                            <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Delete">
                                <i class="fa-solid fa-trash"></i>
                            </span>
                            <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Edit">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>