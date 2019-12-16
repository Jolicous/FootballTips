<form method="post" action="/league/saveTips">
<input type="hidden" name="leagueId" value="<?=$leagueId;?>"/>
<input id="fname" name="id" type="hidden" value="<?=$user->id?>"> 
<?php foreach ($matches as $match): ?>
    <div class="row">
        <div class="col-5">
            <p style="float: right"><?=$match->hometeam;?></p>
        </div>
        <div class="col-2">
            <input name="homegoals_<?=$match->id?>" style="width: 45%" type="number" value="<?=$match->homegoals;?>"/>
            <span> : </span>
            <input name="awaygoals_<?=$match->id?>" style="width: 45%" type="number" value="<?=$match->awaygoals;?>"/>
        </div>
        <div class="col-5">
            <p><?=$match->awayteam;?></p>
        </div>
    </div>
<?php endforeach; ?>
<input style="margin-bottom: 2%" value="Tipps bestätigen" type="submit"/>
</form>
<div class="row">
    <div class="col-12">
        <table class="table">
            <tr>
                <th>Team</th>
                <th>Tore</th>
                <th>Gegentore</th>
                <th>Punkte</th>
            </tr>
            <?php foreach ($table as $entry): ?>
            <tr>
                <td><?=$entry->name;?></td>
                <td><?=$entry->tore;?></td>
                <td><?=$entry->gegentore;?></td>
                <td><?=$entry->punkte;?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>