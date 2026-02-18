<?php

/**
 * Legacy Admin Controller - Backward Compatibility Wrapper
 * This class is kept for backward compatibility only.
 * New functionality has been moved to JE_Unified_Admin_Controller.
 * 
 * @deprecated Use JE_Unified_Admin_Controller instead
 * @author:DerN3rd
 */
class JE_Admin_Controller extends JE_Unified_Admin_Controller {

/**
 * Initialize as a wrapper to the new unified controller
 */
public function __construct() {
parent::__construct();
}
}
?>
