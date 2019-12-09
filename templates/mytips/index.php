<form method="get" action="/mytips/savetips">
<?php foreach ($tips as $tip): ?>
    <div class="row">
        <div class="col-4">
            <p>Manchester United</p>
        </div>
        <div class="col-2">
            <input name="homegoals" style="width: 45%" type="number"/>
            <a> : </a>
            <input name="awaygoals" style="width: 45%" type="number"/>
        </div>
        <div class="col-5">
            <p>Manchester City</p>
        </div>
        <div class="col-1">
            <img style="width: 30px; float: right" src="/images/delete.png" alt="delete">
        </div>
    </div>
<?php endforeach; ?>
<input style="margin-bottom: 2%" value="Tipps bestätigen" type="submit"/>
</form>