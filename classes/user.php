<?php
	require_once('classes/dbw.php');
	class user {
		private $dbc;
		private $userID;
		private $userName;
		private $email;
		private $firstLoginDate;
		private $lastLoginDate;
		private $securityLevel;
		private $enabled;
		
		function user($dbc, $userName) {
			$this->dbc = $dbc;
			$this->userName = $userName;
			
			$data = $dbc->query('
				SELECT UserID, Email, FirstLoginDate, LastLoginDate, SecurityLevel, Enabled
				FROM User 
				WHERE RecordStatus <> 3
				AND UserName = ' .dbw::singleQuote($userName)
			);
			if ($data->num_rows == 1) {
				$row = $data->fetch_assoc();
				$this->userID = $row['UserID'];
				$this->email = $row['Email'];
				$this->firstLoginDate = $row['FirstLoginDate'];
				$this->lastLoginDate = $row['LastLoginDate'];
				$this->securityLevel = $row['SecurityLevel'];
				$this->enabled = $row['Enabled'];
			}
		}
		
		function exists($fromDB = false) {
			return !is_null($this->userID);
		}
		
		function createUser($email,$securityLevel = 1) {
			if (!$this->exists()) {
				$sql = "INSERT INTO User
					  (UserName, Email, FirstLoginDate, LastLoginDate, SecurityLevel, ChangeSource, RecordStatus, RecordStatusDate)
					  VALUES('" .$this->userName  ."','" .$email ."',NOW(), NOW(), " .$securityLevel ."0, 1, NOW())";
				$this->dbc->query($sql);
				$this->userID = $this->getUserID(true);
				return true;
			}
			else return false;
		}
		
		function login() {
			if ($this->exists()) {
				$this->dbc->updateData('User',array(
					'LastLoginDate'=>'NOW()',
					'RecordStatus'=>'2',
					'RecordStatusDate'=>'NOW()'),
				'UserID = ' .$this->getUserID());
				return true;
			}
			else return false;
		}
		
		
		function isEnabled() {
			if ($this->exists()) return $this->enabled == 1;
			else return false;
		}
		
		function isAdmin() {
			if ($this->exists()) return $this->securityLevel == 0;
			else return false;
		}
		
		function setEmail($email) {
			if ($this->exists()) {
				$this->dbc->updateData('User',array('RecordStatus'=>'2','RecordStatusDate'=>'NOW()','Email'=>dbw::singleQuote($email)),'UserID = ' .$this->getUserID());
				$this->email = $email;
				return true;
			}
			else return false;
		}
		
		function setSecurityLevel($securityLevel) {
			if ($this->exists()) {
				$this->dbc->updateData('User',array('RecordStatus'=>'2','RecordStatusDate'=>'NOW()','SecurityLevel'=>$securityLevel),'UserID = ' .$this->getUserID());
				$this->securityLevel = $securityLevel;
				return true;
			}
			else return false;
		}
		
		function getUserID($fromDB = false) {
			if ($fromDB) {
				$this->userID = $this->dbc->queryUnique('User','UserID','UserName = \'' .$this->getUserName() .'\'');
			}
			return $this->userID;
		}
		
		function getUserName() { return $this->userName; }
		function getEmail() { return $this->email; }
		function getFirstLoginDate() { return $this->firstLoginDate; }
		function getLastLoginDate() { return $this->lastLoginDate; }
		function getSecurityLevel() { return $this->securityLevel; }
	}
?>