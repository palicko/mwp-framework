<?php

namespace Modern\Wordpress\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access denied.' );
}

use \Modern\Wordpress\Pattern\Singleton;

/**
 * Plugin Settings
 */
abstract class Settings extends Singleton
{
	
	/**
	 * Instance Cache - Required for singleton
	 * @var	self
	 */
	protected static $_instance;
	
	/**
	 * @var string	Settings Access Key
	 */
	public $key = 'main';
	
	/**
	 * @var array 	Plugin Settings
	 */
	protected $settings;
	
	/**
	 * @var	Plugin
	 */
	protected $plugin;
	
	/**
	 * @var	string
	 */
	protected $storageId;
	
	/**
	 * Constructor
	 *
	 * @return	void
	 */
	protected function __construct()
	{
		if ( ! isset( $this->storageId ) )
		{
			$this->storageId = strtolower( str_replace( '\\', '_', get_class( $this ) ) );
		}
		
		parent::__construct();
	}
	
	/**
	 * Set Plugin
	 *
	 * @return	void
	 */
	public function setPlugin( \Modern\Wordpress\Plugin $plugin )
	{
		$this->plugin = $plugin;
	}
	
	/**
	 * Get Plugin
	 *
	 * @return	Plugin
	 */
	public function getPlugin()
	{
		return $this->plugin;
	}
	
	/**
	 * Get Storage ID
	 *
	 * @return	string
	 */
	public function getStorageId()
	{
		return $this->storageId;
	}
	 
	/**
	 * Get A Setting
	 *
	 * @param	string		$name		The setting name
	 * @return	mixed
	 */
	public function getSetting( $name )
	{
		if ( ! isset( $this->settings ) )
		{
			$this->settings = get_option( $this->storageId, array() );
		}
		
		return isset( $this->settings[ $name ] ) ? $this->settings[ $name ] : NULL;
	}
	
	/**
	 * Set A Setting
	 *
	 * @param	string		$name		The setting name
	 * @param	mixed		$val		The setting value
	 * @return	this
	 */
	public function setSetting( $name, $val )
	{
		if ( ! isset( $this->settings ) )
		{
			$this->settings = get_option( $this->storageId, array() );
		}
		
		return $this;
	}
	
	/**
	 * Persist settings to the database
	 *
	 * @return	this
	 */
	public function saveSettings()
	{
		if ( ! isset( $this->settings ) )
		{
			$this->settings = get_option( $this->storageId, array() );
		}
		
		update_option( $this->storageId, $this->settings );
		return $this;
	}
	
	/**
	 * Validate Settings
	 *
	 * @param	array		$data			Input data
	 * @return	array
	 */
	public function validate( $data=array() )
	{
		return $data;
	}
	
}