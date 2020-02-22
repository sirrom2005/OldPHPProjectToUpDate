<?php

namespace Moneyline\Corporate\Model;

// web services
require_once \COMMON_SERVICE_PATH.'CSFAdminWSService.php';
require_once \COMMON_SERVICE_PATH.'CmoneylineDocLibWSService.php';
require_once \COMMON_SERVICE_PATH.'CSFAdminSupportWSService.php';

// models
require_once \COMMON_MODEL_PATH.'sysinfo.php';
require_once \COMMON_MODEL_PATH.'user.php';

use Raxan;
use Moneyline\Common\DataModelException;
use Moneyline\Common\Model\SysInfo;
use Moneyline\Corporate\Consts;
use Moneyline\Corporate\DataKeys;
use Moneyline\Corporate\Shared;


/**
 * Corporate User Data Model
 * This model contains commonly used functions for the logged in user account
 */
class User extends \Moneyline\Common\Model\User {

    /**
     * Delete User
     * @param int $id
     * @param int $version
     * @return boolean
     */
    public static function deleteUser($id,$version) {
        $user = self::getUserInfo();
        $uid = $user->id;
        $domainId = $user->domainID;
        $sessid = User::getSessionId();
        $client = self::getWebService('CSFAdminWSService');
            $params = new \CSFAdminWSService\deleteSubject();
            $params->userID = $uid;
            $params->sessionID = $sessid;
                $subject = new \CSFAdminWSService\subject();
                    $subject->id = $id;
                    $subject->properties = array();
                    $subject->domainID = $domainId;
                    $subject->versionNbr = $version;
            $params->subject = $subject;
        $rt = $client->deleteSubject($params);
        if (self::checkErrorStatus($rt)) {
            throw new DataModelException(self::$lastErrorCode);
        }
        return true;
    }

    /**
     * Download User document
     */
    public static function downloadDocument($fileUrl) {
        // download documents
        $sessid = self::getSessionId();
        $uid = self::getUserInfo()->id;
        $client = self::getWebService('CmoneylineDocLibWSService');
            $params = new \CmoneylineDocLibWSService\downloadFile();
            $params->sessionID = $sessid;
            $params->userID = $uid;
            $params->fileUrl = $fileUrl;
        $rt = $client->downloadFile($params);
        if (self::checkErrorStatus($rt)) {
            throw new DataModelException(self::$lastErrorCode);
        }
        return $rt->return->applets;
    }

    /**
     * Change password
     * @param string $oldPassword
     * @param string $newPassword
     * @return boolean
     */
    public static function changePassword($oldPassword, $newPassword) {
        // change password
        $client = self::getWebService('CSFAdminWSService');
            $params = new \CSFAdminWSService\changePassword();
            $params->sessionID = self::getSessionId();
            $params->userID = self::getUserId();
            $params->oldPassword = $oldPassword;
            $params->password = $newPassword;
        $rt = $client->changePassword($params);
        if (self::checkErrorStatus($rt)) {
            throw new DataModelException(self::$lastErrorCode);
        }

        // update login info
        $userInfo = self::getUserInfo();
        $userInfo->forcePasswordChange = false;
        $userInfo->passwordExpiryDate = null;

        return true;

    }

    /**
     * Create corporate user account
     * @param \CSFAdminWSService\subject $user
     * @param \CSFAdminWSService\role $roles
     * @return boolean
     */
    public static function createUser($user,$roles) {
        $client = self::getWebService('CSFAdminWSService');
            $params = new \CSFAdminWSService\createSubject();
            $params->userID = self::getUserId();
            $params->sessionID = self::getSessionId();
            $params->subject = $user;
            $params->roles = $roles;
            $params->scope = 'P';
        $rt = $client->createSubject($params);
        if (self::checkErrorStatus($rt)) {
            throw new DataModelException(self::$lastErrorCode);
        }
        return true;
    }

    /**
     * Update corporate user account
     * @param \CSFAdminWSService\subject $user
     * @param \CSFAdminWSService\role $roles
     * @return boolean
     */
    public static function updateUser($user,$roles) {
        $client = self::getWebService('CSFAdminWSService');
            $params = new \CSFAdminWSService\updateSubject();
            $params->userID = self::getUserId();
            $params->sessionID = self::getSessionId();
            $params->subject = $user;
            $params->roles = $roles;
            $params->scope = 'P';
        $rt = $client->updateSubject($params);
        if (self::checkErrorStatus($rt)) {
            throw new DataModelException(self::$lastErrorCode);
        }
        return true;
    }

    /**
     * Find Users By Domain
     * @param string $query
     * @return \CSFAdminWSService\subjects
     */
    public static function findUsersByDomain($query) {
        $userId = self::getUserId();
        $sessId = self::getSessionId();
        $domainId = self::getUserInfo()->domainID;
        $client = self::getWebService('CSFAdminWSService');
            $params = new \CSFAdminWSService\findUsersByDomain();
                $params->sessionID = $sessId;
                $params->userID = $userId;
                $params->domainID = $domainId;
                $params->filterText = $query;
        $rt = $client->findUsersByDomain($params);
        if (self::checkErrorStatus($rt)) {
            throw new DataModelException(self::$lastErrorCode);
        }
        return $rt->return->subjects;
    }

    /**
     * Find Domain Members
     * @param string $query
     * @return \CSFAdminWSService\subjects
     */
    public static function findDomainMembers($query) {
        $domainId = self::getUserInfo()->domainID;
        $client = self::getWebService('CSFAdminSupportWSService');
            $params = new \CSFAdminSupportWSService\findDomainMembersFiltered();
                $params->domainId = $domainId;
                $params->filterText = $query;
        $rt = $client->findDomainMembersFiltered($params);
        if (self::checkErrorStatus($rt)) {
            throw new DataModelException(self::$lastErrorCode);
        }
        return $rt->return->members;
    }


    /**
     * Returns All Domain User accounts
     * @return \CSFAdminSupportWSService\csfUserAccountInfo
     */
    public static function getAllDomainUserAccounts() {
        $domainId = self::getUserInfo()->domainID;
        $client = self::getWebService('CSFAdminSupportWSService');
            $params = new \CSFAdminSupportWSService\generatePossibleUserAccountsInfo();
                $params->domainId = $domainId;
        $rt = $client->generatePossibleUserAccountsInfo($params);
        if (self::checkErrorStatus($rt)) {
            throw new DataModelException(self::$lastErrorCode);
        }
        return $rt->return->info;

    }

    /**
     * Returns Domain Applets
     * @return \CSFAdminWSService\applets
     */
    public static function getDomainApplets() {
        $sessid = self::getSessionId();
        $uid = self::getUserId();
        $domain = self::getUserInfo()->domainID;

        $client = self::getWebService('CSFAdminWSService');
            $params = new \CSFAdminWSService\findDomainApplets();
            $params->sessionID = $sessid;
            $params->userID = $uid;
            $params->domainID = $domain;            
        $rt = $client->findDomainApplets($params);
        if (self::checkErrorStatus($rt)) {
            throw new DataModelException(self::$lastErrorCode);
        }
        return $rt->return->applets;

    }

    public static function getDomainRoles() {
        $sessid = self::getSessionId();
        $uid = self::getUserId();
        $domain = self::getUserInfo()->domainID;

        $client = self::getWebService('CSFAdminWSService');
            $params = new \CSFAdminWSService\findRolesByDomain();
            $params->sessionID = $sessid;
            $params->userID = $uid;
            $params->domainID = $domain;
            $params->loadFeatures = false;
        $rt = $client->findRolesByDomain($params);
        if (self::checkErrorStatus($rt)) {
            throw new DataModelException(self::$lastErrorCode);
        }
        return $rt->return->roles;
    }

    /**
     * Get User Id
     * @return int
     */
    public static function getUserId() {
        $user = Raxan::data(DataKeys::USER_INFO);
        return ($user && $user->id) ? $user->id : null;
    }

    /**
     * Return user Session Id
     * @return int
     */
    public static function getSessionId() {
        return Raxan::data(DataKeys::SESSION_ID);
    }

    /**
     * Returns user information ibject
     * @return \CSFAdminWSService\subject
     */
    public static function getUserInfo() {
        return Raxan::data(DataKeys::USER_INFO);
    }

    /**
     * Return user info with roles
     * @param string $userId
     * @return \CSFAdminWSService\subject
     */
    public static function getUserInfoWithRoles($userId = null) {
        $sessId = self::getSessionId();
        $currentId = self::getUserId();
        $userId = $userId ? $userId : $currentId;

        $client = self::getWebService('CSFAdminWSService');
            $params = new \CSFAdminWSService\findUserWithRoles();
            $params->sessionID = $sessId;
            $params->currentUserID = $currentId;
            $params->userID = $userId; // user to lookup
        $rt = $client->findUserWithRoles($params);
        if (self::checkErrorStatus($rt)) {
            throw new DataModelException(self::$lastErrorCode);
        }
        return $rt->return->subject;        
    }

    /**
     * Return User applets
     * @return \CSFAdminWSService\applet
     */
    public static function getUserApplets() {
        $client = self::getWebService('CSFAdminWSService');
            $id = self::getUserId();
            $params = new \CSFAdminWSService\findUserApplets();
            $params->userID = $id;
            $params->currentUserID = $id;
            $params->sessionID = self::getSessionId();
        $rt = $client->findUserApplets($params);
        if (self::checkErrorStatus($rt)) {
            throw new DataModelException(self::$lastErrorCode);
        }
        return $rt->return->applets;
    }

    
    /**
     * Get User documents
     * @return \CmoneylineDocLibWSService\FileData
     */
    public static function getUserDocuments(){
        $client = self::getWebService('CmoneylineDocLibWSService');
            $params = new \CmoneylineDocLibWSService\getListOfDocuments();
            $params->userID = User::getUserId();
            $params->sessionID = User::getSessionId();
        $rt = $client->getListOfDocuments($params);
        if (self::checkErrorStatus($rt)) {
            throw new DataModelException(self::$lastErrorCode);
        }
        return $rt->return->fileData;
    }


    /**
     * Returns Security questions
     * @return \CSFAdminWSService\securityQuestion
     */
    public static function getSecurityQuestions() {
        $client = self::getWebService('CSFAdminWSService');
            $params = new \CSFAdminWSService\findSecurityQuestions();
            $params->active = true;
        $rt = $client->findSecurityQuestions($params);
        if (self::checkErrorStatus($rt)) {
            throw new DataModelException(self::$lastErrorCode);
        }
        return $rt->return->questions;        
    }

    /**
     * Returns Assigned Security questions for select user
     * @return \CSFAdminWSService\securityQuestion
     */
    public static function getAssignedSecurityQuestions($userName,$domain) {
        $client = self::getWebService('CSFAdminWSService');
            $params = new \CSFAdminWSService\findAssignedSecurityQuestions();
            $params->userName = $userName;
            $params->domainName = $domain;
        $rt = $client->findAssignedSecurityQuestions($params);
        if (self::checkErrorStatus($rt)) {
            throw new DataModelException(self::$lastErrorCode);
        }
        return $rt->return->longs;
    }

    /**
     * User login
     * @param string $domain
     * @param string $user
     * @param string $password
     * @return \CSFAdminWSService\subject
     */
    public static function login($domain,$user,$password) {
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        $client = self::getWebService('CSFAdminWSService');
            $params = new \CSFAdminWSService\authenticate();
            $params->domain = $domain;
            $params->userName = $user;
            $params->password = $password;
            $params->ipAddress = $ipAddress;
        $rt = $client->authenticate($params);
        if (self::checkErrorStatus($rt)) {
            throw new DataModelException(self::$lastErrorCode);
        }

        $userInfo = $rt->return->subject;
        // convert properties to hash-array
        $props = array();
        foreach($userInfo->properties->entry as $entry) {
            $props[$entry->key] = $entry->value;
        }

        // store login info
        $userInfo->properties = $props;
        Raxan::data(DataKeys::VALID_LOGIN, true); // valid login flag
        Raxan::data(DataKeys::USER_INFO, $userInfo); // user info object
        Raxan::data(DataKeys::SESSION_ID, $props['csf.sessionID']); // csf session id
        Raxan::data(DataKeys::SESSION_TRACKING_ID, Raxan::dataStorage()->storageId()); // session tracking id

        return true;
    }

    /**
     * Logout user
     */
    public static function logout() {
        Raxan::data(DataKeys::VALID_LOGIN);
        Raxan::removeData(DataKeys::USER_INFO);
        Raxan::removeData(DataKeys::VALID_LOGIN);
    }

    /**
     * Check user access for required feature
     * @return Boolean
     */
    public static function hasFeature($features) {
        $info = Raxan::data(DataKeys::USER_INFO);
        if ($info && isset($info->features)) {
            if (!is_array($features)) $features = array($features);
            $userFeatures = (is_array($info->features)) ? $info->features : array($info->features);
            foreach($features as $feature) {
                if (in_array($feature,$userFeatures)) return true;
            }
        }
        return false;
    }

    /**
     * Checks if user session is valid
     * @return boolean
     */
    public static function isValidSession() {

        // check if the session is valid
        $sessid = Raxan::data(DataKeys::SESSION_ID);
        $userId = Raxan::data(DataKeys::USER_INFO)->id;
        $client = self::getWebService('CSFAdminWSService');
            $params = new \CSFAdminWSService\isSessionValid();
            $params->sessionID = $sessid;
            $params->userID = $userId;
        $rt = $client->isSessionValid($params);
        if (self::checkErrorStatus($rt)) {
            throw new DataModelException(self::$lastErrorCode);
        }

        return $rt->return; // should extend booleanWrapper?
    }

    /**
     * Check if valid login
     * @return boolean
     */
    public static function isValidUser() {
        return Raxan::data(DataKeys::VALID_LOGIN);
    }


    /**
     * Check user is required to change password
     * @return boolean
     */
    public static function isForcePasswordChange() {
        $userInfo = Raxan::data(DataKeys::USER_INFO);
        $forcedChange = $userInfo->forcePasswordChange;
        $expired = $userInfo->passwordExpiryDate ?
                   strtotime($userInfo->passwordExpiryDate) : 0;
        return  ($forcedChange || ($expired && $expired < time())) ? true : false;
    }

    /**
     * Reset user password by Admin
     * @param int $userId
     * boolean
     */
    public static function resetPasswordByAdmin($userId) {
        $adminId = self::getUserInfo()->id;
        $sessid = self::getSessionId();

        $client = self::getWebService('CSFAdminWSService');
            $params = new \CSFAdminWSService\resetPasswordAdmin();
            $params->userID = $userId;
            $params->sessionID = $sessid;
            $params->updatedBy = $adminId;
        $rt = $client->resetPasswordAdmin($params);
        if (self::checkErrorStatus($rt)) {
            throw new DataModelException(self::$lastErrorCode);
        }
        return $rt->return->success;
    }
    
    /**
     * Reset current user password
     * @param string $domain
     * @param string $userName
     * @param array $answers
     * @return boolean
     */
    public static function resetPassword($domain,$userName,$answers) {
        // reset user password
        $client = self::getWebService('CSFAdminWSService');
            $params = new \CSFAdminWSService\resetPassword();
            $params->domainName = $domain;
            $params->userName = $userName;
            $params->answers = $answers;
        $rt = $client->resetPassword($params);
        if (self::checkErrorStatus($rt)) {
            throw new DataModelException(self::$lastErrorCode);
        }
        return $rt->return->success;
    }

    /**
     * Save Security Answers
     * @param array $answers
     * @return boolean
     */
    public static function saveSecurityAnswers($answers) {
        // save security question
        $client = self::getWebService('CSFAdminWSService');
            $params = new \CSFAdminWSService\saveSecurityAnswers();
            $params->sessionID = self::getSessionId();
            $params->userID = self::getUserId();
            $params->answers = $answers;
        $rt = $client->saveSecurityAnswers($params);
        if (self::checkErrorStatus($rt)) {
            throw new DataModelException(self::$lastErrorCode);
        }
        
        // update user object
        $userInfo = self::getUserInfo();
        $userInfo->hasSecurityQuestions = true;
        
        return $rt->return->success;
    }

    /**
     * Validate user password
     */
    public static function validateUserPass($userId,$pwd) {
        // validate user password and user id
        $sessid = self::getSessionId();
        $client = self::getWebService('CSFAdminWSService');
            $params = new \CSFAdminWSService\isUserValid();
            $params->sessionID = $sessid;
            $params->userID = $userId;
            $params->password = $pwd;
        $rt = $client->isUserValid($params);
        if (self::checkErrorStatus($rt)) {
            throw new DataModelException(self::$lastErrorCode);
        }
        return $rt->return->success;
    }
}



?>
