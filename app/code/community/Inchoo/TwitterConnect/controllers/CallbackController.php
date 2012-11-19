<?php

/**
 * @author Branko Ajzele <ajzele@gmail.com>
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class Inchoo_TwitterConnect_CallbackController extends Mage_Core_Controller_Front_Action {

    public function handleAction() 
    {
        $helper = Mage::helper('inchoo_twitterconnect');
        
        $config=array(
            'callbackUrl' => $helper->getCallbackUrl(),
            'siteUrl' => $helper->getTwitterOauthSiteUrl(),
            'consumerKey' => $helper->getConsumerKey(),
            'consumerSecret' => $helper->getConsumerSecret()
        );
        
        $oauth = new Zend_Oauth_Consumer($config);

        if (isset($_GET['oauth_token']) && isset($_SESSION['inchoo_twitterconnect_request_token'])) {
            try {
                $access = $oauth->getAccessToken($_GET, unserialize($_SESSION['inchoo_twitterconnect_request_token']));
                
                $twitterUserID = (int)$access->getParam('user_id');
                $twitterScreenName = $access->getParam('screen_name');
                
                $customer = Mage::getModel('customer/customer')->getCollection()
                                ->addAttributeToFilter('website_id', array('eq'=>Mage::app()->getWebsite()->getId()))
                                ->addAttributeToFilter('inchoo_twitterconnect_user', array('eq'=>$twitterUserID))
                                ->getFirstItem();
                
                if(!$customer->getId()) {
                    $customer->setEmail(sprintf('%s@user-twitter.com', $twitterScreenName));
                    $customer->setFirstname('Twitter');
                    $customer->setLastname('Customer');
                    $customer->setPassword($customer->generatePassword());
                    $customer->setData('inchoo_twitterconnect_user', $twitterUserID);
                    
                    try {
                        $customer->save();
                        $customer->sendNewAccountEmail('registered', '', Mage::app()->getStore()->getId());
                    } catch (Exception $e) {
                        Mage::logException($e);
                    }               
                }

                if ($customer->getId()) {
                    Mage::getSingleton('customer/session')->loginById($customer->getId());
                }
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('core/session')->addError($e->getMessage());
            }

            $_SESSION['inchoo_twitterconnect_access_token'] = serialize($access);
            $_SESSION['inchoo_twitterconnect_request_token'] = null;

            /*
             *
             * This is where our update stats textbox will be
             *
             */
        } elseif (!empty($_GET['denied'])) {
            Mage::getSingleton('core/session')->addError('You have denied us access to your twitter crendentials');
        } else {
            Mage::getSingleton('core/session')->addError('Invalid callback request. Oops. Sorry.');
        }
        
        $this->_redirect('/');        
    }

}