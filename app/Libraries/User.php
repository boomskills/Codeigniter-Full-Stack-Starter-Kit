<?php

namespace App\Libraries;

/**
 * Returns a complete user account with profile and settings.
 */
class User
{
    public $info = [];
    protected $users_Table = 'users';
    protected $user_profile_Table = 'user_profile';
    protected $user_settings_Table = 'user_settings';
    protected $auth_Table = 'authentications';

    /**
     * @param null|int $userId
     */
    public function __construct(int $userId = 0)
    {
        $select = "
			{$this->users_Table}.id,
			{$this->users_Table}.name,
			{$this->users_Table}.email,
            {$this->users_Table}.phone`,
			{$this->users_Table}.avatar,
            {$this->users_Table}.account_number,
            {$this->auth_Table}.identity as username,
            {$this->auth_Table}.ip_address,
            {$this->auth_Table}.status,
            {$this->auth_Table}.status_message,
            {$this->auth_Table}.active,
            {$this->auth_Table}.online_timestamp,
            {$this->user_profile_Table}.id as profile_id,
            {$this->user_profile_Table}.type as profile_type,
			{$this->user_profile_Table}.first_name,
			{$this->user_profile_Table}.last_name,
			{$this->user_profile_Table}.nickname,
			{$this->user_profile_Table}.birthday,
			{$this->user_profile_Table}.gender,
			{$this->user_profile_Table}.height,
			{$this->user_profile_Table}.weight,
            {$this->user_profile_Table}.cover_image,
            {$this->user_profile_Table}.profile_number,
            {$this->user_profile_Table}.identification_type,
            {$this->user_profile_Table}.identification_number,
			{$this->user_profile_Table}.biography,
            {$this->user_profile_Table}.email_address,
			{$this->user_profile_Table}.phone_number,
			{$this->user_profile_Table}.address,
			{$this->user_profile_Table}.city,
			{$this->user_profile_Table}.state,
			{$this->user_profile_Table}.postal_code,
			{$this->user_profile_Table}.country,
			{$this->user_profile_Table}.show_height,
			{$this->user_profile_Table}.show_weight,
            {$this->user_settings_Table}.email_notification,
            {$this->user_settings_Table}.sms_notification,
            {$this->user_settings_Table}.email_notification_to,
            {$this->user_settings_Table}.sms_notification_to,
            {$this->user_settings_Table}.time_zone,
            {$this->user_settings_Table}.enable_two_factor_auth,
	    ";

        $user = db_connect()->table($this->users_Table)->select($select)
            ->where("{$this->users_Table}.id", $userId)
            ->join("{$this->user_profile_Table}", "{$this->user_profile_Table}.user_id = {$this->users_Table}.id", 'left outer')
            ->join("{$this->user_settings_Table}", "{$this->user_settings_Table}.user_id = {$this->users_Table}.id", 'left outer')
            ->join("{$this->auth_Table}", "{$this->auth_Table}.user_id = {$this->users_Table}.id", 'left outer')
            ->get()->getFirstRow();

        if (!is_null($user)) {
            $this->info = $user;
        }
    }
}
