
<div id="dataMemberPeriodView"> 
<div id="customFieldsMemberPeriod">
   <div class="contact_panel">
      <div class="contactCardLeft">
         <div class="customFieldGroup crm-collapsible ui-corner-all  crm-custom-set-block-1 collapsed">
            <div class="collapsible-title">
              {$membershipPeriodLabels.TitelField}
            </div>
            <div class="crm-summary-block" id="custom-set-block-1--1-1" style="display: none;">
              <table class="crm-info-panel">
               <thead>
                  <tr>
                     <td>{$membershipPeriodLabels.StartDate}</td>
                     <td>{$membershipPeriodLabels.EndDate}</td>
                     <td>{$membershipPeriodLabels.ContributionID}</td>
                  </tr>
               </thead>
               <tbody>
                  {foreach from=$membershipPeriodData item=memberItem key=memeberKey}
                  <tr>
                     <td> {$memberItem.start_date}</td>
                     <td> {$memberItem.end_date}</td>
                     <td class="bold">
            <a href="{crmURL p='civicrm/contact/view/contribution' q="reset=1&id=`$memberItem.contribution_id`&cid=`$memberItem.contact_id`&action=view&context=contribution&selectedChild=contribute"} ">{$memberItem.id}</a></td>
                  
                  </tr>
                  {/foreach}
               </tbody>
              </table>
            </div>
         </div>
      </div>
     
   </div>
</div>
</div>
{literal}
  <script>
    cj(function($){

      $("#contact-summary").append($("#dataMemberPeriodView").html());
      $("#dataMemberPeriodView").remove();
    });
  </script>
{/literal}