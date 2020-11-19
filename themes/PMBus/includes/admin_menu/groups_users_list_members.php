<?php

add_shortcode('groups_users_list_members', 'groups_users_list_members');

function groups_users_list_members( $atts, $content = null ) {
	$output = "";
	$options = shortcode_atts(
		array(
			'group_id' => null
		),
		$atts
	);
	if ($options['group_id']) {
		$group = new Groups_Group($options['group_id']);
		if ($group) {
			$users = $group->__get("users");
			if (count($users)>0) {
				foreach ($users as $group_user) {
					$user = $group_user->user;
					$user_info = get_userdata($user->ID);
					$output .=
					"
						<tr>
							<td width='20%'>" . $user_info-> user_company . "</td>
							<td width='20%'>" . $user_info-> user_login . "</td>
							<td  class='one' width='20%'>" . $user_info-> user_email . "</td>
							<td  class='one' width='20%'>" . $user_info-> billing_phone . "</td>
							<td width='20%'>" . $user_info-> membership . "</td>
						</tr>
					";
      	}
			}
		}
	}
	echo $output;
}
