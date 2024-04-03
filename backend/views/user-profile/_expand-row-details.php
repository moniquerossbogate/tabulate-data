<?php

?>
<div>*insert magandang design here</div>
<div>Contacts</div>
<ul>
    <?php
    foreach ($model->activeContacts as $contact) {
        echo "<li>" . $contact->contact . "</li>";
    }
    ?>
</ul>