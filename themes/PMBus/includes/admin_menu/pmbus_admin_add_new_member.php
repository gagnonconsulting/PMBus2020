<?php
function add_new_members_function() { ?>
	<div style='padding-right: 6%; padding-left: 3%;'>
	<meta name='viewport' content='width=device-width, initial-scale=1'>

	<style>
	* {
    	box-sizing: border-box;
		}
	</style>


	<body>
	<h2 style='font-size: 2em; text-align: center;'>Add New Member</h2>
	<form method="post">
    <input type="submit" name="test" id="test" value="Submit" /><br/>
	</form>
	<?php

function create_new_user()
	{
		$username = 'TestUser';
		$password = 'TempPass01';
		$email = 'TestUser@pmbus.org';
		$user_role = 'Author';
		$company_name = 'Test Company';
		$membership = 'Full-Member-Admin';
		$group = '8';

		$user_id = wp_create_user( $username, $password, $email );
		$user = new WP_User( $user_id );
		$user->set_role('author');
		wp_update_user(array(
        'ID' => $user_id,
        'membership' => $membership,
				'company_name' => $company_name,
    ));

		echo $username . " has been created"; ?>
		<p>Username: <?php echo $username; ?></p>
		<p>Password: <?php echo $password; ?></p>
		<p>Email: <?php echo $email; ?></p>
		<p>User Role: <?php echo $user_role; ?></p>
		<p>Company: <?php echo $company_name; ?></p>
		<p>Membership: <?php echo $membership; ?></p>

		<?php
	}

	if(array_key_exists('test',$_POST)){
		$users = get_users( array( 'fields' => array( 'ID' ) ) );
			foreach($users as $user_id){
        print_r(get_user_meta ( $user_id->ID));
				echo "<br><br>";
    }
		//create_new_user();
	}
}
