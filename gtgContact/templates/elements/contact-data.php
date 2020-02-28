<h4><?php echo get_option( 'gtgContact_title' ); ?></h4>
<div class="col50 col-right-pad">
<address>
    <div><?php echo get_option( 'gtgContact_address_1' );?></div>
    <div><?php echo get_option( 'gtgContact_address_2' );?></div>
    <div><?php echo get_option( 'gtgContact_address_3' );?></div>
    
    <div><a href="tel:+48<?php echo str_replace(' ','',get_option( 'gtgContact_telephone_1' )); ?>"><?php echo get_option( 'gtgContact_telephone_1' ); ?></a></div>
    <div><a href="tel:+48<?php echo str_replace(' ','',get_option( 'gtgContact_telephone_2' )); ?>"><?php echo get_option( 'gtgContact_telephone_2' ); ?></a></div>
</address>
<?php echo $args['response'];?>
</div><div class="col50">
<form method="post" action="/kontakt">
    <input type="hidden" name="gtgcontact-randomString" value="<?php echo $args['randomString'];?>">
        <div>
            <label for="gtgcontact-name">Imię</label>
            <input class="gtgContactInput" type="text" id="gtgcontact-name" name="gtgcontact-name" placeholder="Twoje imię.." required>
        </div>
        <div>
            <label for="gtgcontact-email">Email</label>
            <input class="gtgContactInput" type="email" id="gtgcontact-email" name="gtgcontact-email" placeholder="Twój adres E-mail" required>
        </div>
        <div>
            <label for="gtgcontact-msg"><?php _e('Message','gtgContact');?></label>
            <textarea class="gtgContactInput" id="gtgcontact-msg" name="gtgcontact-msg" placeholder="Wiadomość.." style="height:170px" required></textarea>
        </div>
        <div>
        <input class="gtgContactButton" type="submit" value="Wyślij">
        </div>
</form>
</div>
<div class="map-container">
<iframe src="https://maps.google.com/maps?q=<?php echo str_replace(' ','+',get_option( 'gtgContact_map' )); ?>&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" style="border:0" allowfullscreen></iframe>
</div>