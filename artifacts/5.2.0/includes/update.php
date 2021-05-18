<?php 	

//Exit script if user is in the installation page (_install.php).
//This script only runs when they've installed Sendy
if(currentPage()=='_install.php') return;

//================= Version 1.0.1 =================//
//New column in table: campaigns, named wysiwyg
//=================================================//
$q = "SHOW COLUMNS FROM campaigns WHERE Field = 'wysiwyg'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	$q = 'alter table campaigns add column wysiwyg INT (11) DEFAULT \'0\'';
	$r = mysqli_query($mysqli, $q);
	if ($r){
		$q = 'UPDATE campaigns SET wysiwyg=0';
		$r = mysqli_query($mysqli, $q);
		if ($r){}
	}
}
//================= Version 1.0.3 =================//
//New column in table: login, named tied_to & app
//=================================================//
$q = "SHOW COLUMNS FROM login WHERE Field = 'tied_to' || Field = 'app' || Field = 'paypal'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	$q = 'alter table login add (tied_to INT (11), app INT (11), paypal VARCHAR (100))';
	$r = mysqli_query($mysqli, $q);
	if ($r){}
}
//-------------------------------------------------//
//New column in table: apps, named currency, delivery_fee & cost_per_recipient
//-------------------------------------------------//
$q = "SHOW COLUMNS FROM apps WHERE Field = 'currency' || Field = 'delivery_fee' || Field = 'cost_per_recipient'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	$q = 'alter table apps add (currency VARCHAR (100), delivery_fee VARCHAR (100), cost_per_recipient VARCHAR (100))';
	$r = mysqli_query($mysqli, $q);
	if ($r){}
}
//================= Version 1.0.4 =================//
//New column in table: campaigns, named send_date, lists & timezone
//=================================================//
$q = "SHOW COLUMNS FROM campaigns WHERE Field = 'send_date' || Field = 'lists' || Field = 'timezone'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	$q = 'alter table campaigns add (send_date VARCHAR (100), lists VARCHAR (100), timezone VARCHAR (100))';
	$r = mysqli_query($mysqli, $q);
	if ($r){}
}
//-------------------------------------------------//
//New column in table: login, named, cron
//-------------------------------------------------//
$q = "SHOW COLUMNS FROM login WHERE Field = 'cron'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	$q = 'alter table login add (cron INT (11) default 0)';
	$r = mysqli_query($mysqli, $q);
	if ($r){}
}
//================= Version 1.0.5 =================//
//New column in table: lists, named opt_in, subscribed_url, unsubscribed_url, thankyou, thankyou_message, goodbye, goodbye_message, unsubscribe_all_list
//=================================================//
$q = "SHOW COLUMNS FROM lists WHERE Field = 'opt_in' || Field = 'subscribed_url' || Field = 'unsubscribed_url' || Field = 'thankyou' || Field = 'thankyou_subject' || Field = 'thankyou_message' || Field = 'goodbye' || Field = 'goodbye_subject' || Field = 'goodbye_message' || Field = 'unsubscribe_all_list'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	$q = 'alter table lists add (opt_in INT (11) DEFAULT \'0\', subscribed_url VARCHAR (100), unsubscribed_url VARCHAR (100), thankyou int (11) DEFAULT \'0\', thankyou_subject VARCHAR(100), thankyou_message MEDIUMTEXT, goodbye INT (11) DEFAULT \'0\', goodbye_subject VARCHAR(100), goodbye_message MEDIUMTEXT, unsubscribe_all_list INT (11) DEFAULT \'1\')';
	$r = mysqli_query($mysqli, $q);
	if ($r){}
}
//-------------------------------------------------//
//New column in table: subscribers, named, confirmed
//-------------------------------------------------//
$q = "SHOW COLUMNS FROM subscribers WHERE Field = 'confirmed'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	$q = 'alter table subscribers add (confirmed INT (11) default 1)';
	$r = mysqli_query($mysqli, $q);
	if ($r){}
}

//================= Version 1.0.6 =================//
//New column in table: campaigns, to_send, to_send_lists
//=================================================//
$q = "SHOW COLUMNS FROM campaigns WHERE Field = 'to_send' || Field = 'to_send_lists'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	$q = 'alter table campaigns ADD COLUMN to_send INT (100) AFTER sent';
	$q2 = 'alter table campaigns ADD COLUMN to_send_lists VARCHAR (100) AFTER to_send';
	$r = mysqli_query($mysqli, $q);
	$r2 = mysqli_query($mysqli, $q2);
	if ($r && $r2){}
}
//-------------------------------------------------//
//New column in table: confirm_url
//-------------------------------------------------//
$q = "SHOW COLUMNS FROM lists WHERE Field = 'confirm_url'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	$q = 'alter table lists ADD COLUMN confirm_url VARCHAR (100) AFTER opt_in';
	$r = mysqli_query($mysqli, $q);
	if ($r){}
}

//================= Version 1.0.7 =================//
//New column in table: subscribers, named, complaint
//=================================================//
$q = "SHOW COLUMNS FROM subscribers WHERE Field = 'complaint'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	$q = 'alter table subscribers ADD COLUMN complaint INT (11) DEFAULT \'0\' AFTER bounced';
	$r = mysqli_query($mysqli, $q);
	if ($r){}
}

//================= Version 1.0.8 =================//
//New column in table: lists & subscribers, custom_fields & custom_fields
//=================================================//
$q = "SHOW COLUMNS FROM lists WHERE Field = 'custom_fields'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	$q = 'alter table lists ADD COLUMN custom_fields MEDIUMTEXT';
	$q2 = 'alter table subscribers ADD COLUMN custom_fields LONGTEXT AFTER email';
	$q3 = 'alter table subscribers ADD COLUMN join_date INT (100) AFTER timestamp';
	$r = mysqli_query($mysqli, $q);
	$r2 = mysqli_query($mysqli, $q2);
	$r3 = mysqli_query($mysqli, $q3);
	if ($r && $r2 && $r3){}
}

//================= Version 1.0.9 =================//
//New columns in table: subscribers, login, links and new autoresponders tables
//=================================================//
$q = "SHOW COLUMNS FROM subscribers WHERE Field = 'bounce_soft'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	$q = 'alter table subscribers ADD COLUMN bounce_soft INT (11) DEFAULT \'0\' AFTER bounced, ADD COLUMN last_ares INT (11) AFTER last_campaign';
	$q2 = 'alter table login ADD COLUMN cron_ares INT (11) DEFAULT \'0\' AFTER cron';
	$q3 = 'alter table links ADD COLUMN ares_emails_id INT (11) AFTER campaign_id';
	$q4 = 'CREATE TABLE `ares` (
	  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	  `name` varchar(100) DEFAULT NULL,
	  `type` int(11) DEFAULT NULL,
	  `list` int(11) DEFAULT NULL,
	  `custom_field` varchar(100) DEFAULT NULL,
	  PRIMARY KEY (`id`)
	) AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;';
	$q5 = 'CREATE TABLE `ares_emails` (
	  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	  `ares_id` int(11) DEFAULT NULL,
	  `from_name` varchar(100) DEFAULT NULL,
	  `from_email` varchar(100) DEFAULT NULL,
	  `reply_to` varchar(100) DEFAULT NULL,
	  `title` varchar(500) DEFAULT NULL,
	  `plain_text` mediumtext,
	  `html_text` mediumtext,
	  `time_condition` varchar(100) DEFAULT NULL,
	  `timezone` varchar(100) DEFAULT NULL,
	  `created` int(11) DEFAULT NULL,
	  `recipients` int(100) DEFAULT 0,
	  `opens` longtext,
	  `wysiwyg` int(11) DEFAULT 0,
	  PRIMARY KEY (`id`)
	) AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;';
	$r = mysqli_query($mysqli, $q);
	$r2 = mysqli_query($mysqli, $q2);
	$r3 = mysqli_query($mysqli, $q3);
	$r4 = mysqli_query($mysqli, $q4);
	$r5 = mysqli_query($mysqli, $q5);
	if ($r && $r2 && $r3 && $r4 && $r5){}
}

//================= Version 1.1.0 =================//
//New columns in table: login and new table, queue etc
//=================================================//
$q = "SHOW COLUMNS FROM login WHERE Field = 'send_rate'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	$q = 'alter table login ADD COLUMN send_rate INT (100) DEFAULT 0';
	$q2 = 'alter table login ADD COLUMN timezone VARCHAR (100)';
	$q3 = 'alter table apps ADD (smtp_host VARCHAR (100), smtp_port VARCHAR (100), smtp_ssl VARCHAR (100), smtp_username VARCHAR (100), smtp_password VARCHAR (100))';
	$q4 = 'alter table campaigns ADD COLUMN timeout_check VARCHAR (100) AFTER recipients';
	$r = mysqli_query($mysqli, $q);
	$r2 = mysqli_query($mysqli, $q2);
	$r3 = mysqli_query($mysqli, $q3);
	$r4 = mysqli_query($mysqli, $q4);
	$r5 = mysqli_query($mysqli, $q4);
	if ($r && $r2 && $r3 && $r4){}
	
	$q = 'SELECT timezone FROM login LIMIT 1';
	$r = mysqli_query($mysqli, $q);
	if ($r && mysqli_num_rows($r) > 0)
	{
		while($row = mysqli_fetch_array($r))
		{
			if($row['timezone']=='')
			{
				$q2 = 'UPDATE login SET timezone = "America/New_York" LIMIT 1';
				mysqli_query($mysqli, $q2);
			}
		}  
	}
}

$q = 'SHOW TABLES LIKE "queue"';
$r = mysqli_query($mysqli, $q);
if (mysqli_num_rows($r) == 0)
{
	$q2 = 'CREATE TABLE `queue` (
	  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	  `query_str` longtext,
	  `campaign_id` int(11) DEFAULT NULL,
	  `subscriber_id` int(11) DEFAULT NULL,
	  PRIMARY KEY (`id`)
	) DEFAULT CHARSET=utf8;';
	mysqli_query($mysqli, $q2);
}

//================= Version 1.1.2 =================//
//New column in table: subscribers
//=================================================//
$q = "SHOW COLUMNS FROM campaigns WHERE Field = 'errors'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	$q = 'alter table campaigns ADD COLUMN errors LONGTEXT';
	$r = mysqli_query($mysqli, $q);
	if ($r){}
}

//================= Version 1.1.3 =================//
//New column in table: subscribers
//=================================================//
$q = "SHOW COLUMNS FROM queue WHERE Field = 'sent'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	$q = 'alter table queue ADD COLUMN sent INT (11) DEFAULT 0';
	$r = mysqli_query($mysqli, $q);
	if ($r){}
}

//================= Version 1.1.4 =================//
//New column in table: subscribers
//=================================================//
$q = "SHOW COLUMNS FROM lists WHERE Field = 'confirmation_email'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	$q = 'alter table lists ADD COLUMN confirmation_email MEDIUMTEXT after goodbye_message';
	$r = mysqli_query($mysqli, $q);
	if ($r){}
}
$q = "SHOW COLUMNS FROM lists WHERE Field = 'confirmation_subject'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	$q = 'alter table lists ADD COLUMN confirmation_subject MEDIUMTEXT after goodbye_message';
	$r = mysqli_query($mysqli, $q);
	if ($r){}
}

//================= Version 1.1.5 =================//
//New column in table: subscribers
//=================================================//
$q = "SHOW COLUMNS FROM campaigns WHERE Field = 'bounce_setup'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	$q = 'alter table login ADD language VARCHAR (100) DEFAULT "en_US", ADD cron_csv INT (11) DEFAULT 0';
	$q2 = 'alter table lists ADD prev_count INT (100) DEFAULT 0 after custom_fields, ADD currently_processing INT (100) DEFAULT 0, ADD total_records INT (100) DEFAULT 0';
	$q3 = 'alter table apps ADD bounce_setup INT (11) DEFAULT 0, ADD complaint_setup INT (11) DEFAULT 0';
	$q4 = 'alter table campaigns ADD bounce_setup INT (11) DEFAULT 0, ADD complaint_setup INT (11) DEFAULT 0';
	mysqli_query($mysqli, $q);
	mysqli_query($mysqli, $q2);
	mysqli_query($mysqli, $q3);
	mysqli_query($mysqli, $q4);
}
//add index to list column in subscribers table
$q = 'SHOW INDEX FROM subscribers WHERE KEY_NAME = "s_list"';
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	mysqli_query($mysqli, 'CREATE INDEX s_list ON subscribers (list)');
	mysqli_query($mysqli, 'CREATE INDEX s_unsubscribed ON subscribers (unsubscribed)');
	mysqli_query($mysqli, 'CREATE INDEX s_bounced ON subscribers (bounced)');
	mysqli_query($mysqli, 'CREATE INDEX s_bounce_soft ON subscribers (bounce_soft)');
	mysqli_query($mysqli, 'CREATE INDEX s_complaint ON subscribers (complaint)');
	mysqli_query($mysqli, 'CREATE INDEX s_confirmed ON subscribers (confirmed)');
	mysqli_query($mysqli, 'CREATE INDEX s_timestamp ON subscribers (timestamp)');
	mysqli_query($mysqli, 'CREATE INDEX s_id ON queue (subscriber_id)');
	mysqli_query($mysqli, 'CREATE INDEX st_id ON queue (sent)');
}

//================= Version 1.1.7 =================//
//New column in table: apps
//=================================================//
$q = "SHOW COLUMNS FROM apps WHERE Field = 'app_key'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	$q3 = 'alter table apps ADD COLUMN app_key VARCHAR (100)';
	$r3 = mysqli_query($mysqli, $q3);
	if ($r3)
	{
		$q4 = 'SELECT id FROM apps';
		$r4 = mysqli_query($mysqli, $q4);
		if (mysqli_num_rows($r4) > 0)
		{
			while($row = mysqli_fetch_array($r4))
			{
				$cid = $row['id'];
				
				$q5 = 'UPDATE apps SET app_key = "'.ran_string(30, 30, true, false, true).'" WHERE id = '.$cid;
				mysqli_query($mysqli, $q5);
			}  
		}
	}
}

//================= Version 1.1.7.2 ===============//
//New index in table: subscribers (email column)
//=================================================//
//add index to email column in subscribers table
$q = 'SHOW INDEX FROM subscribers WHERE KEY_NAME = "s_email"';
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	mysqli_query($mysqli, 'CREATE INDEX s_email ON subscribers (email)');
}

//================= Version 1.1.8 ===============//
//New column in table: login
//=================================================//
//Create new 'ses_endpoint' in 'login' table
$q = "SHOW COLUMNS FROM login WHERE Field = 'ses_endpoint'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	$r2 = mysqli_query($mysqli, 'alter table login ADD COLUMN ses_endpoint VARCHAR (100)');
	if($r2)
	{
		$q3 = 'UPDATE login SET ses_endpoint = "email.us-east-1.amazonaws.com" LIMIT 1';
		mysqli_query($mysqli, $q3);
	}
}

//================= Version 1.1.7.3 ===============//
//Convert to_send_lists and lists columns to TEXT type
//=================================================//
//add index to email column in subscribers table
$q = 'SHOW COLUMNS FROM campaigns WHERE Field = "to_send_lists" AND Type = "VARCHAR(100)"';
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 1)
{
	mysqli_query($mysqli, 'ALTER TABLE campaigns MODIFY COLUMN to_send_lists TEXT');
	mysqli_query($mysqli, 'ALTER TABLE campaigns MODIFY COLUMN lists TEXT');
}

//================= Version 1.1.9 ===============//
//New column in table: login
//=================================================//
//Create new 'ses_endpoint' in 'login' table
$q = "SHOW COLUMNS FROM apps WHERE Field = 'allocated_quota'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	mysqli_query($mysqli, 'alter table apps ADD COLUMN allocated_quota INT (11) DEFAULT -1');
	mysqli_query($mysqli, 'alter table apps ADD COLUMN current_quota INT (11) DEFAULT 0');
	mysqli_query($mysqli, 'alter table apps ADD COLUMN day_of_reset INT (11) DEFAULT 1');
	mysqli_query($mysqli, 'alter table apps ADD COLUMN month_of_next_reset VARCHAR (3)');
}

//================= Version 1.1.9.1 ===============//
//New column in table: apps
//=================================================//
//Create new 'test_email' in 'login' table
$q = "SHOW COLUMNS FROM apps WHERE Field = 'test_email'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	mysqli_query($mysqli, 'alter table apps ADD COLUMN test_email VARCHAR (100)');
}

//================= Version 1.1.9.4 ===============//
//New column in table: subscribers
//=================================================//
//Create new 'test_email' in 'login' table
$q = "SHOW COLUMNS FROM subscribers WHERE Field = 'messageID'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	mysqli_query($mysqli, 'alter table subscribers ADD COLUMN messageID VARCHAR (100)');
}

//================= Version 2.0 ===================//
//New table in database: template
//=================================================//
//Create new 'template' table in database
$q = "CREATE TABLE IF NOT EXISTS `template` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userID` int(11) DEFAULT NULL,
  `app` int(11) DEFAULT NULL,
  `template_name` varchar(100) DEFAULT NULL,
  `html_text` mediumtext,
  PRIMARY KEY (`id`)
) AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;";
mysqli_query($mysqli, $q);

//Create new 'query_string' in 'campaigns' table
$q = "SHOW COLUMNS FROM campaigns WHERE Field = 'query_string'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	mysqli_query($mysqli, 'alter table campaigns ADD COLUMN query_string VARCHAR (500) AFTER html_text, ADD COLUMN label VARCHAR (500) AFTER title');
	mysqli_query($mysqli, 'alter table ares_emails ADD COLUMN query_string VARCHAR (500) AFTER html_text');
	mysqli_query($mysqli, 'alter table apps ADD COLUMN brand_logo_filename VARCHAR (100)');
}

//================= Version 2.0.6 ===============//
//New column in table: apps
//=================================================//
//Create new 'allowed_attachments' in 'apps' table
$q = "SHOW COLUMNS FROM apps WHERE Field = 'allowed_attachments'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	mysqli_query($mysqli, 'alter table apps ADD COLUMN allowed_attachments VARCHAR (100) DEFAULT "jpeg,jpg,gif,png,pdf,zip"');
}

//================= Version 2.0.8 ===============//
//New INDEX in table: subscribers and increase VARCHAR to 1500 in `link` column of `links` table
//=================================================//
//Create new 'allowed_attachments' in 'apps' table
$q = "SHOW INDEX FROM subscribers WHERE Key_name = 's_last_campaign'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	mysqli_query($mysqli, 'ALTER TABLE subscribers ADD INDEX s_last_campaign (last_campaign DESC)');
	mysqli_query($mysqli, 'ALTER TABLE links modify link VARCHAR(1500)');
	mysqli_query($mysqli, 'ALTER TABLE apps CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
	mysqli_query($mysqli, 'ALTER TABLE ares_emails CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
	mysqli_query($mysqli, 'ALTER TABLE campaigns CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
	mysqli_query($mysqli, 'ALTER TABLE lists CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
	mysqli_query($mysqli, 'ALTER TABLE subscribers CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
	mysqli_query($mysqli, 'ALTER TABLE template CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
}

//================= Version 2.1.0 ===============//
//New column in table: auth_enabled, auth_key
//=================================================//
//Create new 'allowed_attachments' in 'apps' table
$q = "SHOW COLUMNS FROM login WHERE Field = 'auth_enabled'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	mysqli_query($mysqli, 'ALTER TABLE login ADD COLUMN auth_enabled INT (11) DEFAULT 0');
	mysqli_query($mysqli, 'ALTER TABLE login ADD COLUMN auth_key VARCHAR (100)');
}

//================= Version 2.1.1 ===============//
//New table: zapier
//=================================================//

//Create new 'zapier' table in database
$q = "CREATE TABLE IF NOT EXISTS `zapier` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `subscribe_endpoint` varchar(100) DEFAULT NULL,
  `event` varchar(100) DEFAULT NULL,
  `list` int(11) DEFAULT NULL,
  `app` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;";
mysqli_query($mysqli, $q);

//================= Version 2.1.1.5 ===============//
//New column in 'apps' table: reports_only 
//=================================================//

//Create new 'reports_only' in 'apps' table
$q = "SHOW COLUMNS FROM apps WHERE Field = 'reports_only'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	mysqli_query($mysqli, 'ALTER TABLE apps ADD COLUMN reports_only INT (1) DEFAULT 0');
	mysqli_query($mysqli, 'ALTER TABLE campaigns ADD COLUMN opens_tracking INT (1) DEFAULT \'1\', ADD COLUMN links_tracking INT (1) DEFAULT \'1\'');
	mysqli_query($mysqli, 'ALTER TABLE ares_emails ADD COLUMN opens_tracking INT (1) DEFAULT \'1\', ADD COLUMN links_tracking INT (1) DEFAULT \'1\'');
	mysqli_query($mysqli, 'ALTER TABLE login CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
}

//================= Version 2.1.2.7 ===============//
//New column in 'apps' table: year_of_next_reset 
//=================================================//

//Create new 'reports_only' in 'apps' table
$q = "SHOW COLUMNS FROM apps WHERE Field = 'year_of_next_reset'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	mysqli_query($mysqli, 'ALTER TABLE apps ADD COLUMN year_of_next_reset VARCHAR (4) AFTER month_of_next_reset');
	mysqli_query($mysqli, 'ALTER TABLE campaigns ADD COLUMN quota_deducted INT (11) AFTER wysiwyg');
	
	//Init
	$time_today_unix = time();
	$month_today = strftime("%m", $time_today_unix);
	$year_today = strftime("%Y", $time_today_unix);
	$year_last = $year_today-1;
	$month_array = array(1=>'Jan', 2=>'Feb', 3=>'Mar', 4=>'Apr', 5=>'May', 6=>'Jun', 7=>'Jul', 8=>'Aug', 9=>'Sep', 10=>'Oct', 11=>'Nov', 12=>'Dec');
	
	//Populate empty 'year_of_next_reset' columns if a monthly sending limit was set
	$q2 = 'SELECT id, allocated_quota, month_of_next_reset FROM apps';
	$r2 = mysqli_query($mysqli, $q2);
	if ($r2 && mysqli_num_rows($r2) > 0)
	{
		while($row = mysqli_fetch_array($r2))
		{
			$app_id = $row['id'];
			$allocated_quota = $row['allocated_quota'];
			
			//If a monthly sending limit was set, set 'year_of_next_reset' appropriately
			if($allocated_quota!='-1')
			{
				$month_of_next_reset = array_search($row['month_of_next_reset'], $month_array);
				$month_diff = $month_of_next_reset - $month_today;
				if($month_diff > 1) mysqli_query($mysqli, "UPDATE apps SET year_of_next_reset = $year_last WHERE id = $app_id");
				else mysqli_query($mysqli, "UPDATE apps SET year_of_next_reset = $year_today WHERE id = $app_id");
			}
		}  
	}
}

//================= Version 3.0 ===============//
//New column in table: lists_excl
//=================================================//
//Create new 'allowed_attachments' in 'apps' table
$q = "SHOW COLUMNS FROM campaigns WHERE Field = 'lists_excl'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	mysqli_query($mysqli, 'ALTER TABLE campaigns ADD COLUMN lists_excl MEDIUMTEXT AFTER lists, ADD COLUMN segs MEDIUMTEXT AFTER lists_excl, ADD COLUMN segs_excl MEDIUMTEXT AFTER segs');
	mysqli_query($mysqli, 'CREATE TABLE IF NOT EXISTS `seg` (
	  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	  `name` varchar(100) DEFAULT NULL,
	  `app` int(11) DEFAULT NULL,
	  `list` int(11) DEFAULT NULL,
	  `last_updated` varchar(100) DEFAULT NULL,
	  PRIMARY KEY (`id`)
	) AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;');
	mysqli_query($mysqli, 'CREATE TABLE IF NOT EXISTS `seg_cons` (
	  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	  `seg_id` int(11) DEFAULT NULL,
	  `group_id` int(11) DEFAULT NULL,
	  `operator` char(3) DEFAULT NULL,
	  `field` varchar(100) DEFAULT NULL,
	  `comparison` varchar(11) DEFAULT NULL,
	  `val` varchar(500) DEFAULT NULL,
	  PRIMARY KEY (`id`)
	) AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;');
	mysqli_query($mysqli, 'CREATE TABLE `subscribers_seg` (
	  `seg_id` int(11) DEFAULT NULL,
	  `subscriber_id` int(11) DEFAULT NULL
	) DEFAULT CHARSET=utf8;');
	mysqli_query($mysqli, 'CREATE INDEX s_sid ON subscribers_seg (seg_id)');
	mysqli_query($mysqli, 'CREATE INDEX s_subscriber_id ON subscribers_seg (subscriber_id)');
	mysqli_query($mysqli, 'CREATE INDEX s_list ON seg (list)');
	mysqli_query($mysqli, 'CREATE INDEX s_seg_id ON seg_cons (seg_id)');
	mysqli_query($mysqli, 'ALTER TABLE subscribers ADD INDEX s_messageid (messageID)');
	mysqli_query($mysqli, 'ALTER TABLE queue ADD INDEX s_campaign_id (campaign_id)');
	mysqli_query($mysqli, 'ALTER TABLE login ADD COLUMN cron_seg INT (11) DEFAULT \'0\' AFTER cron_csv');
	
	if(mysqli_query($mysqli, 'ALTER TABLE apps ADD COLUMN campaigns_only INT (1) DEFAULT 0, ADD COLUMN templates_only INT (1) DEFAULT 0, ADD COLUMN lists_only INT (1) DEFAULT 0'))
	{
		$q2 = 'SELECT id, reports_only FROM apps';
		$r2 = mysqli_query($mysqli, $q2);
		if ($r2 && mysqli_num_rows($r2) > 0)
		{
			while($row = mysqli_fetch_array($r2))
			{
				$aid = $row['id'];
				$ro = $row['reports_only'];
				if($ro==1)
				{
					mysqli_query($mysqli, 'UPDATE apps SET reports_only = 0, campaigns_only = 1, templates_only = 1, lists_only = 1 WHERE id = '.$aid);
				}
			}  
		}
	}
}

//================= Version 3.0.4 ===============//
//New column in table: ares_emails
//=================================================//
//Create new 'allowed_attachments' in 'apps' table
$q = "SHOW COLUMNS FROM ares_emails WHERE Field = 'enabled'";
$r = mysqli_query($mysqli, $q);
if (mysqli_num_rows($r) == 0)
{
	mysqli_query($mysqli, 'ALTER TABLE ares_emails ADD COLUMN enabled INT (11) DEFAULT \'0\' AFTER links_tracking');
	mysqli_query($mysqli, 'UPDATE ares_emails SET enabled = 1');
	mysqli_query($mysqli, 'ALTER TABLE subscribers_seg ADD PRIMARY KEY(seg_id, subscriber_id)');
}

//================= Version 3.0.5 ===============//
//New columns in table: subscribers
//=================================================//
//Create new columns in 'apps' table
$q = "SHOW COLUMNS FROM subscribers WHERE Field = 'ip'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	mysqli_query($mysqli, 'ALTER TABLE subscribers 
	  ADD COLUMN ip VARCHAR (100)
	, ADD COLUMN country VARCHAR (2)
	, ADD COLUMN referrer VARCHAR (500)
	, ADD COLUMN method INT (1)
	, ADD COLUMN added_via INT (1)
	');
	mysqli_query($mysqli, 'ALTER TABLE apps ADD COLUMN notify_campaign_sent INT (1) DEFAULT \'1\'');
	mysqli_query($mysqli, 'CREATE INDEX s_country ON subscribers (country)');
	mysqli_query($mysqli, 'CREATE INDEX s_referrer ON subscribers (referrer)');
	mysqli_query($mysqli, 'CREATE INDEX s_method ON subscribers (method)');
	mysqli_query($mysqli, 'CREATE INDEX s_added_via ON subscribers (added_via)');
}

//================= Version 3.0.6 ===============//
//New columns in table: apps
//=================================================//
//Create new columns in 'apps' table
$q = "SHOW COLUMNS FROM apps WHERE Field = 'campaign_report_rows'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	mysqli_query($mysqli, 'ALTER TABLE apps ADD COLUMN campaign_report_rows INT (11) DEFAULT \'10\'');
	mysqli_query($mysqli, 'ALTER TABLE apps ADD COLUMN query_string VARCHAR (500)');
	mysqli_query($mysqli, 'ALTER TABLE login ADD COLUMN reset_password_key VARCHAR (20)');
}

//================= Version 3.0.7 ===============//
//New columns in table: lists
//=================================================//
//Create new columns in 'apps' table
$q = "SHOW COLUMNS FROM lists WHERE Field = 'gdpr_enabled'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	mysqli_query($mysqli, 'ALTER TABLE lists 
	ADD COLUMN gdpr_enabled INT (1) DEFAULT \'0\', 
	ADD COLUMN marketing_permission MEDIUMTEXT, 
	ADD COLUMN what_to_expect MEDIUMTEXT, 
	ADD COLUMN gdpr INT (1) DEFAULT \'0\' AFTER total_records');
	mysqli_query($mysqli, 'ALTER TABLE apps ADD COLUMN gdpr_only INT (1) DEFAULT \'0\', 
	ADD COLUMN gdpr_options INT (1) DEFAULT \'1\'');
	mysqli_query($mysqli, 'ALTER TABLE subscribers ADD COLUMN gdpr INT (1) DEFAULT \'0\'');
}

//================= Version 3.0.8 ===============//
//New columns in table: apps
//=================================================//
//Create new columns in 'apps' table
$q = "SHOW COLUMNS FROM apps WHERE Field = 'gdpr_only_ar'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	mysqli_query($mysqli, 'ALTER TABLE apps ADD COLUMN gdpr_only_ar INT (1) DEFAULT \'0\'');
	
	$q = 'SELECT id, gdpr_only FROM apps';
	$r = mysqli_query($mysqli, $q);
	if ($r && mysqli_num_rows($r) > 0)
	{
		while($row = mysqli_fetch_array($r))
		{
			$app_id = $row['id'];
			$gdpr_only = $row['gdpr_only'];
			$q2 = 'UPDATE apps SET gdpr_only_ar = '.$gdpr_only.' WHERE id = '.$app_id;
			$r2 = mysqli_query($mysqli, $q2);
			if ($r2){}
		}  
	}
}

//================= Version 3.1.2 ===============//
//New columns in table: apps
//=================================================//
//Create new columns in 'apps' table
$q = "SHOW COLUMNS FROM apps WHERE Field = 'recaptcha_sitekey'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	mysqli_query($mysqli, 'ALTER TABLE apps ADD COLUMN recaptcha_sitekey VARCHAR (50)');
	mysqli_query($mysqli, 'ALTER TABLE apps ADD COLUMN recaptcha_secretkey VARCHAR (50)');
}

//================= Version 3.1.2.1 ===============//
//New index in table: apps
//=================================================//
//add index to gdpr column in subscribers table
$q = 'SHOW INDEX FROM subscribers WHERE KEY_NAME = "s_gdpr"';
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	mysqli_query($mysqli, 'CREATE INDEX s_gdpr ON subscribers (gdpr)');
}

//================= Version 3.1.2.2 ===============//
//New index in table: apps
//=================================================//
//Create new columns in 'lists' table
$q = "SHOW COLUMNS FROM lists WHERE Field = 'unsubscribe_confirm'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	mysqli_query($mysqli, 'ALTER TABLE lists ADD COLUMN unsubscribe_confirm INT (1) DEFAULT \'0\'');
}

//================= Version 4.0 ===============//
//New tables: suppression_list and blocked_domains
//=================================================//
//Create new columns in 'lists' table
$q = "SELECT id FROM suppression_list";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	mysqli_query($mysqli, '
	CREATE TABLE `suppression_list` (
	  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	  `app` int(11) DEFAULT NULL,
	  `email` varchar(100) DEFAULT NULL,
	  `timestamp` varchar(100) DEFAULT NULL,
	  `block_attempts` int(100) DEFAULT \'0\',
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8');
	
	mysqli_query($mysqli, '
	CREATE TABLE `blocked_domains` (
	  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	  `app` int(11) DEFAULT NULL,
	  `domain` varchar(100) DEFAULT NULL,
	  `timestamp` varchar(100) DEFAULT NULL,
	  `block_attempts` int(100) DEFAULT \'0\',
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8');
	
	mysqli_query($mysqli, '
	CREATE TABLE `skipped_emails` (
	  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	  `app` int(11) DEFAULT NULL,
	  `list` int(11) DEFAULT NULL,
	  `email` varchar(100) DEFAULT NULL,
	  `reason` int(1) DEFAULT NULL,
	  PRIMARY KEY (`id`),
	  KEY `s_list` (`list`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;');
	
	mysqli_query($mysqli, 'ALTER TABLE apps 
						   ADD COLUMN custom_domain VARCHAR (100),
						   ADD COLUMN custom_domain_protocol VARCHAR (5),
						   ADD COLUMN custom_domain_enabled INT (1) DEFAULT \'0\',
						   ADD COLUMN test_email_prefix VARCHAR (100),
						   ADD COLUMN no_expiry INT (1) DEFAULT \'0\' AFTER year_of_next_reset');
	mysqli_query($mysqli, 'ALTER TABLE lists
						   ADD COLUMN no_consent_url VARCHAR (100),
						   ADD COLUMN already_subscribed_url VARCHAR (100),
						   ADD COLUMN reconsent_success_url VARCHAR (100)');
	mysqli_query($mysqli, 'ALTER TABLE template MODIFY template_name VARCHAR(500)');
	mysqli_query($mysqli, 'ALTER TABLE subscribers ADD COLUMN notes TEXT');
}

//================= Version 4.0.2 ===============//
//
//=================================================//
//Create new columns in 'lists' table
$q = "SELECT templates_lists_sorting FROM apps";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	mysqli_query($mysqli, 'ALTER TABLE apps ADD COLUMN templates_lists_sorting VARCHAR(4) DEFAULT "date"');
}

//================= Version 4.0.3 ===============//
//New columns in table: apps
//=================================================//
//Create new columns in 'apps' table
$q = "SHOW COLUMNS FROM login WHERE Field = 'brands_rows'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	mysqli_query($mysqli, 'ALTER TABLE login ADD COLUMN brands_rows INT (11) DEFAULT \'10\'');
}

//================= Version 4.0.4 ===============//
//New columns in table: apps
//=================================================//
//Create new columns in 'apps' table
$q = "SHOW COLUMNS FROM queue WHERE Field = 'http_headers'";
$r = mysqli_query($mysqli, $q);
if (mysqli_num_rows($r) == 0)
{
	mysqli_query($mysqli, 'ALTER TABLE queue ADD COLUMN http_headers MEDIUMTEXT AFTER query_str');
}

//================= Version 4.0.6.1 ===============//
//New columns in table: lists
//=================================================//
//Create new columns in 'lists' table
$q = "SHOW COLUMNS FROM seg_cons WHERE Field = 'grouping'";
$r = mysqli_query($mysqli, $q);
if (mysqli_num_rows($r) == 1)
{
	mysqli_query($mysqli, 'ALTER TABLE seg_cons CHANGE `grouping` group_id int(11)');
}

//================= Version 4.0.9 ===============//
//New columns in table: lists
//=================================================//
//Create new columns in 'lists' table
$q = "SHOW COLUMNS FROM login WHERE Field = 'api_key_prev'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	mysqli_query($mysqli, 'ALTER TABLE login ADD api_key_prev VARCHAR(500) AFTER api_key');
	mysqli_query($mysqli, 'ALTER TABLE login ADD strict_delete INT(1) DEFAULT 1');
}

//================= Version 4.1.0 ===============//
//New columns in table: lists
//=================================================//
//Create new columns in 'lists' table
$q = "SHOW COLUMNS FROM skipped_emails LIKE 'id'";
$r = mysqli_query($mysqli, $q);
if (mysqli_num_rows($r) == 0)
{
	mysqli_query($mysqli, 'ALTER TABLE skipped_emails ADD COLUMN id int(11) unsigned primary KEY AUTO_INCREMENT');
}

//================= Version 5 ===============//
//New columns in table: lists
//=================================================//
//Create new columns in 'lists' table
$q = "SHOW COLUMNS FROM login WHERE Field = 'dark_mode'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	mysqli_query($mysqli, 'ALTER TABLE login ADD dark_mode INT(1) DEFAULT 0');
	mysqli_query($mysqli, 'ALTER TABLE template ADD plain_text longtext');
	mysqli_query($mysqli, 'ALTER TABLE ares_emails ADD segs longtext, ADD segs_excl longtext');
	
	mysqli_query($mysqli, '
	CREATE TABLE `rules` (
	  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	  `brand` int(11) DEFAULT NULL,
	  `trigger` varchar(100) DEFAULT NULL,
	  `action` varchar(100) DEFAULT NULL,
	  `endpoint` varchar(100) DEFAULT NULL,
	  `notification_email` varchar(100) DEFAULT NULL,
	  `unsubscribe_list_id` int(11) DEFAULT NULL,
	  `list` int(11) DEFAULT NULL,
	  `app` int(11) DEFAULT NULL,
	  `ares_id` int(11) DEFAULT NULL,
	  PRIMARY KEY (`id`),
	  KEY `s_brand` (`brand`) USING BTREE,
	  KEY `s_trigger` (`trigger`) USING BTREE,
	  KEY `s_action` (`action`) USING BTREE,
	  KEY `s_list` (`list`) USING BTREE,
	  KEY `s_app` (`app`) USING BTREE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;');
	
	mysqli_query($mysqli, '
	CREATE TABLE `webhooks_log` (
	  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	  `rule` int(11) DEFAULT NULL,
	  `endpoint` varchar(100) DEFAULT NULL,
	  `payload` mediumtext,
	  `status_code` varchar(10) DEFAULT NULL,
	  `status_message` mediumtext,
	  `timestamp` varchar(100) DEFAULT NULL,
	  PRIMARY KEY (`id`),
	  KEY `s_brand` (`rule`) USING BTREE,
	  KEY `s_status_code` (`status_code`) USING BTREE 
	) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;');
	
	//Move list signup notifications and auto unsubscribe data to 'Rules' table
	$q = 'SELECT id, app, notify_new_signups, notification_email, unsubscribe_from_list, unsubscribe_list_id FROM lists';
	$r = mysqli_query($mysqli, $q);
	if ($r && mysqli_num_rows($r) > 0)
	{
		while($row = mysqli_fetch_array($r))
		{
			$list_id = $row['id'];
			$app = $row['app'];
			$notify_new_signups = $row['notify_new_signups'];
			$notification_email = $row['notification_email'];
			$unsubscribe_from_list = $row['unsubscribe_from_list'];
			$unsubscribe_list_id = $row['unsubscribe_list_id'];
			
			if($notify_new_signups)
			{
				$q2 = 'INSERT INTO rules (`brand`, `trigger`, `action`, `notification_email`, `list`) VALUES ('.$app.', "subscribe", "notify", "'.$notification_email.'", '.$list_id.')';
				$r2 = mysqli_query($mysqli, $q2);
				if (!$r2) error_log("[Unable to INSERT into 'rules' table]".mysqli_error($mysqli).': in '.__FILE__.' on line '.__LINE__);
			}
			
			if($unsubscribe_from_list)
			{
				$q3 = 'INSERT INTO rules (`brand`, `trigger`, `action`, `unsubscribe_list_id`, `list`) VALUES ('.$app.', "subscribe", "unsub_from_list", "'.$unsubscribe_list_id.'", '.$list_id.')';
				$r3 = mysqli_query($mysqli, $q3);
				if (!$r3) error_log("[Unable to INSERT into 'rules' table]".mysqli_error($mysqli).': in '.__FILE__.' on line '.__LINE__);
			}
		}  
		
		//Drop columns
		$q = 'ALTER TABLE lists DROP notify_new_signups, DROP notification_email, DROP unsubscribe_from_list, DROP unsubscribe_list_id;';
		$r = mysqli_query($mysqli, $q);
		if(!$r) error_log("[Unable to DROP columns in 'lists' table]".mysqli_error($mysqli).': in '.__FILE__.' on line '.__LINE__);
	}
	else error_log("[Unable to SELECT data from 'lists' table]".mysqli_error($mysqli).': in '.__FILE__.' on line '.__LINE__);
	
	//Create campaign sent notifications rules
	$q = 'SELECT * FROM apps';
	$r = mysqli_query($mysqli, $q);
	if ($r && mysqli_num_rows($r) > 0)
	{
		while($row = mysqli_fetch_array($r))
		{
			$app = $row['id'];
			$from_email = $row['from_email'];
			
			$q2 = 'INSERT INTO rules (`brand`, `trigger`, `action`, `notification_email`, `app`) VALUES ('.$app.', "campaign_sent", "notify", "'.$from_email.'", '.$app.')';
			$r2 = mysqli_query($mysqli, $q2);
			if (!$r2) error_log("[Unable to INSERT into 'rules' table]".mysqli_error($mysqli).': in '.__FILE__.' on line '.__LINE__);
		}  
	}
	else error_log("[Unable to SELECT data from 'apps' table]".mysqli_error($mysqli).': in '.__FILE__.' on line '.__LINE__);
}

//================= Version 5.2 ===============//
//New columns in table: login
//=================================================//
//Create new column in 'login' table
$q = "SHOW COLUMNS FROM login WHERE Field = 'auth_salt'";
$r = mysqli_query($mysqli, $q);
if (!$r || mysqli_num_rows($r) == 0)
{
	$r2 = mysqli_query($mysqli, 'ALTER TABLE login ADD auth_salt VARCHAR(20) AFTER ses_endpoint');
	if($r2)
	{
		$auth_salt = ran_string(20, 20, true, false, true);
		
		$q3 = 'UPDATE login SET auth_salt = "'.$auth_salt.'" WHERE id = 1';
		$r3 = mysqli_query($mysqli, $q3);
		if (!$r3)
		{
			error_log("[Can\'t UPDATE auth_salt in login table]".mysqli_error($mysqli).': in '.__FILE__.' on line '.__LINE__);
		}
	}
	else
	{
		error_log("[Can\'t run ALTER TABLE login ADD auth_salt VARCHAR(20) AFTER ses_endpoint]".mysqli_error($mysqli).': in '.__FILE__.' on line '.__LINE__);
	}
}
?>