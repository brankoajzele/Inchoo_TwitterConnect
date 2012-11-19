<?php
/**
 * @author Branko Ajzele <ajzele@gmail.com>
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class Inchoo_TwitterConnect_Model_Config_Button_Style
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'button', 'label'=>Mage::helper('inchoo_twitterconnect')->__('Button')),
            array('value' => 'link', 'label'=>Mage::helper('inchoo_twitterconnect')->__('Link')),
        );
    }
}