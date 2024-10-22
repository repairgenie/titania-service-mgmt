<?php
	/**
	 * @file
	 * This file contains hook functions that get called when a new member signs up, 
	 * when a member signs in successfully and when a member fails to sign in.
	*/

	/**
	 * This hook function is called when a member successfully signs in. 
	 * It can be used for example to redirect members to specific pages rather than the home page, 
	 * or to save a log of members' activity, ... etc.
	 * 
	 * @param $memberInfo
	 * An array containing logged member's info
	 * @see https://bigprof.com/appgini/help/working-with-generated-web-database-application/hooks/memberInfo
	 * 
	 * @param $args
	 * An empty array that is passed by reference. It's currently not used but is reserved for future uses.
	 * 
	 * @return
	 * A string containing the URL to redirect the member to. It can be a relative or absolute URL. 
	 * If the return string is empty, the member is redirected to the homepage (index.php).
	*/

	function login_ok($memberInfo, &$args) {

		return '';
	}

	/**
	 * This hook function is called when a login attempt fails.
	 * It can be used for example to log login errors.
	 * 
	 * @param $attempt
	 * An associative array that contains the following members:
	 * $attempt['username']: the username used to log in
	 * $attempt['password']: the password used to log in
	 * $attempt['IP']: the IP from wihich the login attempt was made
	 * 
	 * @param $args
	 * An empty array that is passed by reference. It's currently not used but is reserved for future uses.
	 * 
	 * @return
	 * None.
	*/

	function login_failed($attempt, &$args) {

	}

	/**
	 * This hook function is called when a new member signs up.
	 * 
	 * @param $memberInfo
	 * An array containing logged member's info
	 * @see https://bigprof.com/appgini/help/working-with-generated-web-database-application/hooks/memberInfo
	 * 
	 * @param $activity
	 * A string that takes one of the following values:
	 * 'pending': 
	 *     Means the member signed up through the signup form and awaits admin approval.
	 * 'automatic':
	 *     Means the member signed up through the signup form and was approved automatically.
	 * 'profile':
	 *     Means the member made changes to his profile.
	 * 'password':
	 *     Means the member changed his password.
	 * 
	 * @param $args
	 * An empty array that is passed by reference. It's currently not used but is reserved for future uses.
	 * 
	 * @return
	 * None.
	*/

	function member_activity($memberInfo, $activity, &$args) {
		switch($activity) {
			case 'pending':
				break;

			case 'automatic':
				break;

			case 'profile':
				break;

			case 'password':
				break;

		}
	}

	/**
	 * This hook function is called when an email is being sent
	 * 
	 * @param $pm is the PHPMailer object, passed by reference in order to easily modify its properties.
	 *            Documentation and examples can be found at https://github.com/PHPMailer/PHPMailer
	 *  
	 * @return none
	 */
	function sendmail_handler(&$pm) {

	}

	/**
	 * Modify options for displaying child records in the detail view of
	 * a parent record
	 *
	 * Config for the current child table and lookup field is accessible
	 * at $config[$childTable][$childLookupField]
	 * 
	 * For documentation of the contents of this array, please
	 * @see https://bigprof.com/appgini/help/advanced-topics/hooks/global-hooks#child_records_config
	 * 
	 * For default configuration, please check the $pcConfig array defined in the
	 * generated parent-children.php file
	 * 
	 * @param      string  $childTable        The current child table name
	 * @param      string  $childLookupField  The name of the lookup field in the child table 
	 *                                        that is linked to the parent table
	 * @param      array   $config            The configuration array for displaying child records
	 *                                        for the current user, passed by reference
	 * 
	 * @return none
	 */
	function child_records_config($childTable, $childLookupField, &$config) {

	}

