<?php


/**
 * Class to process contact for extension
 *
 * @author Alexander Ferreras  aferreras@gmail.com
 * @date 24 Mar 2018
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
class CRM_MembershipPeriod_Controller
{
    

    /**
     *Data from db
     **/
    private $data = array();

    /*
     ** Set array labels from view
     */
    private $labels;
      /*
     ** Constant name of page
     */
    static $pageNameValidate = "CRM_Contact_Page_View_Summary";
    /*
     * Template CRM
     */
    static $templateContactSummary = "Membershipperiod.tpl";

    /*
     ** This function, set labels to template
     */
    static function labelsSet()
    {
       return array(
            "TitelField" => ts("Membership Period"),
            "StartDate" => ts("Start Date"),
            "EndDate" => ts("End Date"),
            "ContributionID" => ts("Contribution Id"),
            "LinkConstribution" => ts("Membership Period")
        );
    }
    
    
    
    
    /*
     *Prepare all Data
     * Validate if exist list of entity in DB and set values to var data
     *$page var or event pageRun
     */
    static function preapreMembershipPeriod($page)
    {
        $contactId = $page->getVar('_contactId');
        $data      = civicrm_api3('MembershipPeriod', 'get', array(
            'contact_id' => $contactId
        ));
        $count     = $data["count"];
        $values    = $data["values"];
        $resultData = array();

        foreach ($values  as $key => $value) {
            $contribution_id_g = $value['contribution_id'];
            $resultData[$contribution_id_g ] = $value;
        }

        if ($count > 0) {
            $labels = self::labelsSet();
            $page->assign('membershipPeriodLabels', $labels);
            $page->assign('membershipPeriodData',$resultData);
            return true;
        }
        
        return false;
    }
  
    
    
    /**
     * Method to process the civicrm pageRun hook
     * Render in URL /civicrm/contact/view
     * @param $page
     */
    public static function pageRun(&$page)
    {
        $pageName = $page->getVar('_name');
        // only if contact summary
        if ($pageName == self::$pageNameValidate) {
            
            if (self::preapreMembershipPeriod($page)) {
                
                CRM_Core_Region::instance('page-body')->add(array(
                    'template' => 'CRM/Membershipperiod/' .self::$templateContactSummary
                ));
            }
            
            //}
        }
    }
    
    
    /*
    * pre is the preparing  membershipperiod_civicrm_pre
    *
    */
    public static function pre($op, $objectName, $objectId, &$objectRef)
    {
        
        if ($objectName == "MembershipPayment" && $op == "create") {
            $contribution_id = $objectRef["contribution_id"];
            
            $dataContribution = civicrm_api3("Contribution", "get", array(
                "contribution_id" => $contribution_id
            ));
            
            $contactId    = $dataContribution['values'][$contribution_id]['contact_id'];
            $receive_date = $dataContribution['values'][$contribution_id]['receive_date'];
            try {
                $date_end = date('Y-m-d', strtotime($receive_date. ' + 365 days'));
                civicrm_api3('MembershipPeriod', 'create', array(
                    'contact_id' => $contactId,
                    'contribution_id' => $contribution_id,
                    'start_date' => $receive_date,
                    'end_date' => $date_end
                ));
                
            }
            catch (CiviCRM_API3_Exception $e) {
                //This save in the database log, but where is the Entity Log_Of_Errors?
                $error = $e->getMessage();
            }
            
        }
        
        
    }
}