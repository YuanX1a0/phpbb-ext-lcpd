<?php
/**
 *
 * LSPD论坛徽章. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2025, siwode, https://my.siwode.net
 * @copyright (c) 2025-2026, Yuanx1a0
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace siwode\lcpd;

/**
 * LSPD论坛徽章 Service info.
 */
class service
{
	/** @var \phpbb\user */
	protected $user;

	/** @var string */
	protected $table_name;

	/**
	 * Constructor
	 *
	 * @param \phpbb\user $user       User object
	 * @param string      $table_name The name of a db table
	 */
	public function __construct(\phpbb\user $user, $table_name)
	{
		$this->user = $user;
		$this->table_name = $table_name;
	}

	/**
	 * Get user object
	 *
	 * @return \phpbb\user $user User object
	 */
	public function get_user()
	{
		var_dump($this->table_name);
		return $this->user;
	}
}
