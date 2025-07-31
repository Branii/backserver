<?php

class partnerController extends Controller
{

    public function notfound()
    {
        $this->view("html/notfound");
        $this->view->render();
    }
//NOTE -
    ////////////// PARTNERS  FUNCTIONS -//////////

      public function  editPartnerMainInfo($partnerID, $partnerName, $siteUrl, $adminSiteUrl, $clientMinAge, $verificationType, $unusedWithdrawalAmount, $priority, $state, $currency)
    {

        $this->view('exec/partners', ["partner_id" => $partnerID, "partner_name" => $partnerName, "currency" => $currency, "site_url" => $siteUrl, "admin_site_url" => $adminSiteUrl, "client_min_age" => $clientMinAge, "verification_type" => $verificationType, "unused_withdrawal_amount" => $unusedWithdrawalAmount, "priority" => $priority, "state" => $state, 'flag' => 'editPartnerMainInfo']);
        $this->view->render();
    }

        public function  editPartnerCurrencySettings($partnerID, $currencies)
    {
        $this->view('exec/partners', ["partner_id" => $partnerID, "currencies" => $currencies, 'flag' => 'editPartnerCurrencySettings']);
        $this->view->render();
    }

     public function  editPartnerlanguagesSettings($partnerID, $languages)
    {
        $this->view('exec/partners', ["partner_id" => $partnerID, "languages" => $languages, 'flag' => 'editPartnerlanguagesSettings']);
        $this->view->render();
    }

       public function  editPartnerLotteries($partnerID, $lotteries)
    {
        $this->view('exec/partners', ["partner_id" => $partnerID, "lotteries" => $lotteries, 'flag' => 'editPartnerLotteries']);
        $this->view->render();
    }

      public function searchPartnersNames($partnerID, $partnerName)
    {

        $this->view('exec/partners', ['partner_id' => $partnerID, 'partnerName' => $partnerName, 'flag' => 'searchPartnersNames']);
        $this->view->render();
    }

       public function  searchPartners($partnerName, $state, $startDate, $endDate, $page, $limit)
    {
        $this->view('exec/partners', ["partnerName" => $partnerName, "state" => $state, "startDate" => $startDate, "endDate" => $endDate, "page" => $page, "limit" => $limit, 'flag' => 'searchPartners']);
        $this->view->render();
    }

       public function  editPaymentPlaftorm($partnerID, $paymentType, $paymentTypeName, $currency, $status, $fee, $maxAmount, $minAmount, $siteUrl, $adminSiteUrl, $info, $priority, $countries)
    {
        $this->view('exec/payment_platform', ['partner_id' => $partnerID, "paymentType" => $paymentType, "paymentTypeName" => $paymentTypeName, "currency" => $currency, "status" => $status, "fee" => $fee, "maxAmount" => $maxAmount, "minAmount" => $minAmount, "siteUrl" => $siteUrl, "adminSiteUrl" => $adminSiteUrl, "info" => $info, "priority" => $priority, "countries" => $countries, 'flag' => 'editPaymentPlaftorm']);
        $this->view->render();
    }

        public function  fetchPartners($partnerID, $page, $limit)
    {
        $this->view('exec/partners', ['partner_id' => $partnerID, "page" => $page, "limit" => $limit, 'flag' => 'fetch_partners']);
        $this->view->render();
    }

     public function  fetchPartnersNames($partnerID, $page, $limit)
    {
        $this->view('exec/partners', ['partner_id' => $partnerID, 'flag' => 'fetchPartnersNames']);
        $this->view->render();
    }

       public function filterPartnerPaymentPlatforms($partnerID, $blocked_payment_platforms, $payment_platform_id, $currency_types, $status, $startDate, $endDate, $page, $limit)
    {
        $this->view('exec/partners', [
            'partner_id' => $partnerID,
            'blocked_payment_platforms' => $blocked_payment_platforms,
            'payment_platform_id' => $payment_platform_id,
            'currency_types' => $currency_types,
            'status' => $status,
            'startdate' => $startDate,
            'enddate' => $endDate,
            'page' => $page,
            'limit' => $limit,
            'flag' => 'filterPartnerPaymentPlatforms'
        ]);
        $this->view->render();
    }


          public function  addNewPartner($partnerName, $currency, $encodedSiteUrl, $encodedAdminSiteUrl)
    {

        
        $this->view('exec/partners', ["partner_name" => $partnerName, "currency" => $currency, "site_url" => $encodedSiteUrl, "admin_site_url" => $encodedAdminSiteUrl, 'flag' => 'addNewPartner']);
        $this->view->render();
    }


    public function  fetchPaymentPlatforms($partnerID, $page, $limit)
    {
        $this->view('exec/payment_platforms', ['partner_id' => $partnerID, 'flag' => 'fetchpaymentplatforms']);
        $this->view->render();
    }

      public function fetchAgentSubs($partnerID, $agent_id, $lottery_id, $start_date, $end_date, $flag, $page, $limit)
    {
        $this->view('exec/win_loss', ['partner_id' => $partnerID, "agent_id" => $agent_id, 'lottery_id' => $lottery_id, 'start_date' => $start_date, 'end_date' => $end_date, 'page' => $page, 'limit' => $limit, 'flag' => $flag]);
        $this->view->render();
    }

        public function fetchLotteries($partnerID, $flag)
    {
        $this->view('exec/partners', ['partner_id' => $partnerID, "flag" => $flag]);
        $this->view->render();
    }

   


}