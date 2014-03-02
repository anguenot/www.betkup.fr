<div class="topMenu topMenu<?php echo Ucfirst($type_invite) ?>">
    <ul>
        <li class="normal menuEmail <?php if ($type_invite == 'email'): ?>selectedInvite<?php endif ?> first">
        	<div class="arrow"></div>
        	<table class="invite-menu-table">
        		<tbody>
        			<tr>
        				<td>
        					<div class="picto"></div>
        				</td>
        				<td>
        					<a href="javascript:void(0);" onclick="loadContent(this, 'email', 'invite', 'emails');"  title="E-mail"><?php echo __('label_invite_left_menu_email') ?></a>
        				</td>
        			</tr>
        		</tbody>
        	</table>
        </li>
        <li class="normal menuFacebook <?php if ($type_invite == 'facebook'): ?>selectedInvite<?php endif ?>">
        	<div class="arrow"></div>
        	<table class="invite-menu-table">
        		<tbody>
        			<tr>
        				<td>
        				<div class="picto"></div>
        				</td>
        				<td>
        					<a href="javascript:void(0);" onclick="loadContent(this, 'facebook', 'invite', 'facebook');" title="Facebook"><?php echo __('label_invite_left_menu_facebook') ?></a>
        				</td>
        			</tr>
        		</tbody>
        	</table>
        </li>
        <li class="normal menuTwitter <?php if ($type_invite == 'twitter'): ?>selectedInvite<?php endif ?>">
        	<div class="arrow"></div>
        	<table class="invite-menu-table">
        		<tbody>
        			<tr>
        				<td>
        					<div class="picto"></div>
        				</td>
        				<td>
        					<a href="javascript:void(0);" onclick="loadContent(this, 'twitter', 'invite', 'twitter');" title="Twitter"><?php echo __('label_invite_left_menu_twitter') ?></a>
        				</td>
        			</tr>
        		</tbody>
        	</table>
        </li>
        <li class="normal menuLink <?php if ($type_invite == 'link'): ?>selectedInvite<?php endif ?>">
        	<div class="arrow"></div>
        	<table class="invite-menu-table">
        		<tbody>
        			<tr>
        				<td>
        					<div class="picto"></div>
        				</td>
        				<td>
        					<a href="javascript:void(0);" onclick="loadContent(this, 'link', 'invite', 'link');" title="Url Link"><?php echo __('label_invite_left_menu_url') ?></a>
        				</td>
        			</tr>
        		</tbody>
        	</table>
        </li>
    </ul>
</div>