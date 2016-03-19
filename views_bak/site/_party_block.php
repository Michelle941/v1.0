<?php
foreach ($parties as $party) {
    if(strtotime($party->started_at) > time())
        echo $this->render('_upcomingPartyOnMainPage', ['party' => $party]);
    else
        echo $this->render('_pastPartyOnMainPage', ['party' => $party]);
}