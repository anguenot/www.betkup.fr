<div class="multimedia">
    <?php include_component('home', 'slide', array()) ?>
    <?php if(!$sf_user->isAuthenticated()) : ?>
    <?php include_component('account', 'createAccountOnHome', array()) ?>
    <?php else : ?>
    <?php include_component('home', 'readyToPlayHomeBox', array()) ?>
    <?php endif; ?>
</div>
<div class="home" align="center">
    <div class="top"></div>
    <?php include_component('kup', 'home', array('titre' => __('label_home_kups_front'), 'kupsData' => $kupsData)) ?>
    <?php include_component('room', 'home', array('titre' => __('label_home_rooms_front'), 'roomsData' => $roomsData)) ?>
    <div class="vide">
      <img src="/images/home/trait.png" border="0" alt="" />
    </div>
    <!--?php include_component('home', 'live', array('rankingData' => $rankingData, 'feedData' => $feedData)) ?-->
    <!--div class="vide">
      <img src="/images/home/trait2.png" border="0" alt="" />
    </div-->
    <?php include_component('home', 'quotes', array('quotesData' => $quotesData)) ?>
    <div class="vide">
      <img src="/images/home/trait2.png" border="0" alt="" />
    </div>
    <?php include_component('home', 'facebook', array()) ?>
	<div class="formulaire">
        <?php if (!$sf_user->hasCredential('member')) : ?>
            <?php include_component('home', 'register', array()) ?>
        <?php endif; ?>
		<div style="display: block; height: 15px;"></div>
        <div class="facebook">
            <div class="fb-like" data-href="https://www.betkup.fr" data-send="true" data-width="450" data-show-faces="false" data-action="recommend"></div>
        </div>
    </div>
</div>