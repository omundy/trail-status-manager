<?php
/**
 * Plugin Name: Trail Status Manager
 * Plugin URI: http://owenmundy.com/site/critical-web-design
 * Description: A wordpress plugin!
 * Version: 0.1
 * Author: Owen Mundy
 * Author URI: http://owenmundy.com
 */


// Start up the engine
class Trail_Status_Mgr
{
    /**
     * Static property to hold our singleton instance
     */
    public static $instance = false;

    /**
     * Constructor
     */
    private function __construct()
    {
        // add JS and meta tag
        add_action('admin_enqueue_scripts', array( $this, 'admin_scripts'));
    }

    /**
     * If an instance exists, this returns it.  If not, it creates one and retuns it.
     *
     * @return Trail_Status_Mgr
     */

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }


    /**
     * Add JS and meta tags
     */
    public function admin_scripts()
    {
        $this->add_meta_flag();
        wp_enqueue_script('trail-manager-script', plugins_url('trail-status-manager/main.js', _FILE_));
    }

    /**
     * Add meta tag
     */
    public function add_meta_flag()
    {
		$user = wp_get_current_user();
		// print_r($user->roles);

        if (current_user_can('editor') || current_user_can('administrator')) {
            // administrators or editors
            print '<meta name="trail-manager" content="false">';
        } else if ($user->roles[0] == "trailmanager"){
            print '<meta name="trail-manager" content="true">';
        }
    }
} /// end class
// Instantiate class
$Trail_Status_Mgr = Trail_Status_Mgr::getInstance();
