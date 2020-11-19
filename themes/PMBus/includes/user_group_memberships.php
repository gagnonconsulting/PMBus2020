<?php
function user_group_memberships( $user_id = null, $show_hidden = false ) {

	$group_ids = groups_get_user_groups($user_id);

	$visible_group_ids = array();

	foreach($group_ids["groups"] as $group_id) {
		if (!$show_hidden) {
			if(groups_get_group(array( 'group_id' => $group_id )) -> status !== 'hidden') {
			$visible_group_ids[] = $group_id;
			}
		} else {
		$visible_group_ids[] = $group_id;
		}
	}

	if (empty($visible_group_ids)) {
		echo 'None';
	} else {
		foreach($visible_group_ids as $visible_group_id) {
			echo(
				'<a title="View group page" href="' . home_url() . '/groups/' . groups_get_group(array( 'group_id' => $visible_group_id )) -> slug . '">' .
				groups_get_group(array( 'group_id' => $visible_group_id )) -> name . '</a>' .
				(end($visible_group_ids) == $visible_group_id ? '' : ', ' )
			);
		}
	}
}
