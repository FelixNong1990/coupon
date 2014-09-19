<?php
// DATABASE RELATED CODE

function _dbConnect() {
	$sFullHost = DATABASE_HOST;
	$sFullHost .= DATABASE_PORT ? ':'.DATABASE_PORT : '';
	$sFullHost .= DATABASE_SOCK ? ':'.DATABASE_SOCK : '';

	$GLOBALS['rDbLink'] = @mysql_pconnect($sFullHost, DATABASE_USER, DATABASE_PASS);
	if (!$GLOBALS['rDbLink']) {
		_generateError('Database connect failed', false);

		return false;
	}

	if (!_dbSelect())
		_generateError('Database select failed');

	mysql_query("SET NAMES 'utf8'", $GLOBALS['rDbLink']);
	mysql_query("SET sql_mode = ''", $GLOBALS['rDbLink']);

	return true;
}

function _dbSelect() {
	return @mysql_select_db(DATABASE_NAME, $GLOBALS['rDbLink']);
}

/**
 * close mysql connection
 */
function _dbDisconnect() {
	mysql_close($GLOBALS['rDbLink']);
}

/**
 * execute any query and return number of rows affected or false
 */
function _dbQuery($query) {
	$res = _dbRes($query);
	if($res)
		return mysql_affected_rows($GLOBALS['rDbLink']);

	return false;
}

/**
 * execute any query
 */
function _dbRes($query)	{
	if(!$query)
		return false;

	$res = @mysql_query($query, $GLOBALS['rDbLink']);

	// we need to remeber last error message since mysql_ping will reset it on the next line
	if (false === $res)
		$sOldSqlErrorMessage = @mysql_error($GLOBALS['rDbLink']);

	// if mysql connection is lost, reconnect and try again
	if (false === $res && !@mysql_ping($GLOBALS['rDbLink'])) {
		@mysql_close($GLOBALS['rDbLink']);
		_dbConnect();
		$res = mysql_query($query, $GLOBALS['rDbLink']);
	}

	if (!$res)
		_generateError('Database query error', true, $sOldSqlErrorMessage);

	return $res;
}

function _dbGetErrorMessage () {
	$s = mysql_error($GLOBALS['rDbLink']);
	if ($s)
		return $s;
	else
		return 'no sql error';
}

function _generateError($sError, $isCheckSqlError = true, $sOldSqlErrorMessage = false) {
	if ($isCheckSqlError)
		$sError .= ': ' . _dbGetErrorMessage();
	if ($sOldSqlErrorMessage)
		$sError .= ' Old error:' . $sOldSqlErrorMessage;

	print($sError);
	echo '<br>';
}

function _addRequestToDB($aSTWArgs, $aResponse, $sHash) {
	$iTimestamp = time();

	$sQueryUpdate = "UPDATE `stw_requests` SET `timestamp` = '" . $iTimestamp . "', `capturedon` = '" . $aResponse['stw_last_captured'] . "', `invalid` = '" . $aResponse['invalid'] . "',
		`stwerrcode` = '" . $aResponse['stw_response_code'] . "', `error` = '" . $aResponse['error'] . "', `errcode` = '" . $aResponse['stw_response_status'] . "' WHERE `hash` = '" . $sHash . "'";
	$sQueryInsert = "INSERT INTO `stw_requests` SET `domain` = '" . $aSTWArgs['stwurl'] . "', `timestamp` = '" . $iTimestamp . "', `capturedon` = '" . $aResponse['stw_last_captured'] . "',
		`quality` = '" . $aSTWArgs['stwqual'] . "', `full` = '" . $aSTWArgs['stwfull'] . "', `xmax` = '" . $aSTWArgs['stwxmax'] . "', `ymax` = '" . $aSTWArgs['stwymax'] . "',
		`nrx` = '" . $aSTWArgs['stwnrx'] . "', `nry` = '" . $aSTWArgs['stwnry'] . "', `invalid` = '" . $aResponse['invalid'] . "', `stwerrcode` = '" . $aResponse['stw_response_code'] . "',
		`error` = '" . $aResponse['error'] . "', `errcode` = '" . $aResponse['stw_response_status'] . "', `hash` = '" . $sHash . "'";

	// check if there is an entry existing with this hash
	if (_dbQuery($sQueryUpdate) == 0) { // doesn't exist
		_dbRes($sQueryInsert);
	}
}

function addAccountInfoToDB($sKeyID, $aResponse) {
	$iTimestamp = time();

    $sQueryUpdate = "UPDATE `stw_acc_info` SET `account_level` = '" . $aResponse['stw_account_level'] . "', `inside_pages` = '" . $aResponse['stw_inside_pages'] . "', `custom_size` = '" . $aResponse['stw_custom_size'] . "',
            `full_length` = '" . $aResponse['stw_full_length'] . "', `refresh_ondemand` = '" . $aResponse['stw_refresh_ondemand'] . "', `custom_delay` = '" . $aResponse['stw_custom_delay'] . "', `custom_quality` = '" . $aResponse['stw_custom_quality'] . "',
            `custom_resolution` = '" . $aResponse['stw_custom_resolution'] . "', `custom_messages` = '" . $aResponse['stw_custom_messages'] . "', `timestamp` = '" . $iTimestamp . "' WHERE `key_id` = '" . $sKeyID . "'";
    $sQueryUpdate = "IINSERT INTO `stw_acc_info` SET `key_id` = '" . $sKeyID . "', `account_level` = '" . $aResponse['stw_account_level'] . "', `inside_pages` = '" . $aResponse['stw_inside_pages'] . "', `custom_size` = '" . $aResponse['stw_custom_size'] . "',
            `full_length` = '" . $aResponse['stw_full_length'] . "', `refresh_ondemand` = '" . $aResponse['stw_refresh_ondemand'] . "', `custom_delay` = '" . $aResponse['stw_custom_delay'] . "', `custom_quality` = '" . $aResponse['stw_custom_quality'] . "',
            `custom_resolution` = '" . $aResponse['stw_custom_resolution'] . "', `custom_messages` = '" . $aResponse['stw_custom_messages'] . "', `timestamp` = '" . $iTimestamp . "'";

	// check if there is an entry existing with this key_id
	if (_dbQuery($sQueryUpdate) == 0) { // doesn't exist
		_dbRes($sQueryInsert);
	}
}

function getAccountInfoFromDB($sKeyID) {
    return _dbRes("SELECT * FROM `stw_acc_info` WHERE `key_id` = '" . $sKeyID . "' LIMIT 1");
}

?>