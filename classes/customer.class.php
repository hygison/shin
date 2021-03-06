<?php
    /**
     * @author Hygison Brandao hygisonbrandao@gmail.com
     * 
     * Class responsible for clients
     * Rules:
     * - Each client must belong to a company
     * - Send Message to client - Emails
     * - Store client historic
     * - Track client
     * - Share Google Sheet with client
     * 
     * 
     * 
     * Dbh Table:
     * id
     * firstName
     * familyName
     * companyName
     * isActive
     */


    class Customer{

        public $customerName;
        public $customerID;
        public $customerEmail;
        public $customerCompany;

        public function setCustomerName(string $customerName){
            $this->customerName = $customerName;
        }
        public function setCustomerID(string $customerID){
            $this->customerID = $customerID;
        }
        public function setCustomerEmail(string $customerEmail){
            $this->customerEmail = $customerEmail;
        }
        public function setCustomerCompany(string $customerCompany){
            $this->customerCompany = $customerCompany;
        }

        public function getCustomerName(){
            return $this->customerName;
        }
        public function getCustomerID(){
            return $this->customerID;
        }
        public function getCustomerEmail(){
            return $this->customerEmail;
        }
        public function getCustomerCompany(){
            return $this->customerCompany;
        }

        public function insertDbhCustomer(){
            
        }

    }



?>