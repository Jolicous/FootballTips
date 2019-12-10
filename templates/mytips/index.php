
<form method="post" action="/mytips/savetips">
<?php $i = 0 ?>
<?php foreach ($tips as $tip): ?>
    <div class="row">
        <div class="col-4">
            <p><?=$tip->hometeam;?></p>
        </div>
        <div class="col-2">
            <input name="homegoals_<?=$tip->id;?>" style="width: 45%" type="number" value="<?=$tip->homegoals;?>"/>
            <span> : </span>
            <input name="awaygoals_<?=$tip->id;?>" style="width: 45%" type="number" value="<?=$tip->awaygoals;?>"/>
        </div>
        <div class="col-5">
            <p><?=$tip->awayteam;?></p>
        </div>
        <div class="col-1">
            <a href="/mytips/deleteEntry?index=<?=$i;?>">
                <img style="width: 30px; float: right" src="/images/delete.png" alt="delete">
            </a>
        </div>
    </div>
<?php $i++ ?>
<?php endforeach; ?>
<input style="margin-bottom: 2%" value="Tipps bestätigen" type="submit"/>
</form>