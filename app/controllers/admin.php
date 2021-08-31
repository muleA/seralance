<?php
    namespace Controller;
    ob_start();// to avoid header() error. should be put at first
    class Admin extends Controller{
        
        public function home(){
            $this->view('administrator/dashboard');
        }

        public function logout(){
            session_destroy();
            header("Location: http://localhost/seralance/public/");                
            exit();
        }

        public function profile(){
            $this->view('administrator/updateprofile');
        }

        public function adminusers(){
            $this->view('administrator/admin_users');
        }

        public function serviceproviders(){
            $this->view('administrator/serviceproviders');
        }

        public function serviceseekers(){
            $this->view('administrator/serviceseekers');
        }

        public function bids(){
            $this->view('administrator/bids');
        }

        public function announcedprojects(){
            $this->view('administrator/announced');
        }

        public function offeredprojects(){
            $this->view('administrator/offered');
        }

        public function opentickets(){
            $this->view('administrator/open_tickets');
        }

        public function closedtickets(){
            $this->view('administrator/closed_tickets');
        }

        public function reply($ticketId){
            $_SESSION['ticketid'] = $ticketId;
            $this->view('administrator/replyticket');
            unset($_SESSION['ticketid']);
        }

        public function viewadmin($username){
            $admin = $this->model('Admin');
            $_SESSION['adminDetails'] = $admin->retrieveUserDetails($username);
            if($_SESSION['adminDetails']==false){
                unset($_SESSION['adminDetails']);
                header("Location: http://localhost/seralance/public/admin/home");                
                exit();
            }

            $this->view('administrator/admindetails');
            unset($_SESSION['adminDetails']);
        }

        public function viewticket($ticketId){
            $ticket = $this->model('Ticket');
            $_SESSION['ticketDetails'] = $ticket->retrieveTicketDetails($ticketId);
            if($_SESSION['ticketDetails']==false){
                unset($_SESSION['ticketDetails']);
                header("Location: http://localhost/seralance/public/admin/home");                
                exit();
            }
            if(empty($_SESSION['ticketDetails']['closed_date'])){
                $_SESSION['ticketDetails'] = array_merge($_SESSION['ticketDetails'], array('closed_date'=>'---'));
            }
            if(empty($_SESSION['ticketDetails']['reply'])){
                $_SESSION['ticketDetails'] = array_merge($_SESSION['ticketDetails'], array('reply'=>'---'));
            }

            $this->view('administrator/ticketdetails');
            unset($_SESSION['ticketDetails']);
        }

        public function newadmin(){
            $this->view('administrator/create_new_admin');
        }

        public function getUserDetails($username){
            $admin = $this->model('Admin');
            return $admin->retrieveUserDetails($username);
        }

        public function getAdmins(){
            $admin = $this->model('Admin');
            return $admin->retrieveAdmins();
        }

        public function getServiceProviders(){
            $serviceProvider = $this->model('ServiceProvider');
            return $serviceProvider->retrieveServiceProviders();
        }

        public function getServiceSeekers(){
            $serviceSeeker = $this->model('ServiceSeeker');
            return $serviceSeeker->retrieveServiceSeekers();
        }

        public function getAllBids(){
            $bid = $this->model('Bid');
            return $bid->retrieveAllBids();
        }

        public function getAllAnnouncedProjects(){
            $project = $this->model('Project');
            return $project->retrieveAllAnnouncedProjects();
        }

        public function getAllOfferedProjects(){
            $project = $this->model('Project');
            return $project->retrieveAllOfferedProjects();
        }

        public function getAllOpenTickets(){
            $ticket = $this->model('Ticket');
            return $ticket->retrieveAllOpenTickets();
        } 

        public function getAllClosedTickets(){
            $ticket = $this->model('Ticket');
            return $ticket->retrieveAllClosedTickets();
        } 

        public function getAllCountries(){
            require_once('../app/models/countries.php');
            return \Countries::$countries;
        }

        public function viewserviceprovider($username){                 
            $serviceProvider = $this->model('ServiceProvider');
            
            $_SESSION['serviceProviderDetails'] = $serviceProvider->retrieveServiceProviderDetails($username);
            if($_SESSION['serviceProviderDetails']==false){
                unset($_SESSION['serviceProviderDetails']);
                header("Location: http://localhost/seralance/public/admin/serviceproviders");                
                exit();
            }
            $this->view('administrator/provider_profile');
            unset($_SESSION['serviceProviderDetails']);
        }

        public function viewbiddescription($bidId){
            $bid = $this->model('Bid');
            $_SESSION['bidDetails'] = $bid->retrieveBidDetails($bidId);
            if($_SESSION['bidDetails']==false){
                unset($_SESSION['bidDetails']);
                header("Location: http://localhost/seralance/public/admin/");                
                exit();
            }

            $this->view('administrator/biddescription');
            unset($_SESSION['bidDetails']);
            
        }

        public function viewproject($projectId){
            $project = $this->model('Project');
            $_SESSION['projectDetails'] = $project->retrieveProjectDetails($projectId);
            if($_SESSION['projectDetails']==false){
                unset($_SESSION['projectDetails']);
                header("Location: http://localhost/seralance/public/admin/");                
                exit();
            }

            if(empty($_SESSION['projectDetails']['price'])){
                $_SESSION['projectDetails'] = array_merge($_SESSION['projectDetails'], array('price'=>'---'));
            }
            if(empty($_SESSION['projectDetails']['start_date'])){
                $_SESSION['projectDetails'] = array_merge($_SESSION['projectDetails'], array('start_date'=>'---'));
            }
            if(empty($_SESSION['projectDetails']['end_date'])){
                $_SESSION['projectDetails'] = array_merge($_SESSION['projectDetails'], array('end_date'=>'---'));
            }
            if(empty($_SESSION['projectDetails']['file'])){
                $_SESSION['projectDetails'] = array_merge($_SESSION['projectDetails'], array('file'=>'---'));
            }
            if(empty($_SESSION['projectDetails']['delivered_file'])){
                $_SESSION['projectDetails'] = array_merge($_SESSION['projectDetails'], array('delivered_file'=>'---'));
            }
            if(empty($_SESSION['projectDetails']['assigned_to'])){
                $_SESSION['projectDetails'] = array_merge($_SESSION['projectDetails'], array('assigned_to'=>'---'));
            }

            $this->view('administrator/projectdetails');
            unset($_SESSION['projectDetails']);
            
        }

        public function viewserviceseeker($username){                 
            $serviceSeeker = $this->model('ServiceSeeker');
            
            $_SESSION['serviceSeekerDetails'] = $serviceSeeker->retrieveUserDetails($username);
            if($_SESSION['serviceSeekerDetails']==false){
                unset($_SESSION['serviceSeekerDetails']);
                header("Location: http://localhost/seralance/public/admin/serviceseekers");                
                exit();
            }
            $this->view('administrator/seeker_profile');
            unset($_SESSION['serviceSeekerDetails']);
        }

        public function suspend($usertype,$username){
            $user = $this->model('User');
            $user->suspend($username);
            if($usertype == 'serviceprovider'){
                header("Location: http://localhost/seralance/public/admin/serviceproviders");  
            }
            if($usertype == 'serviceseeker'){
                header("Location: http://localhost/seralance/public/admin/serviceseekers");  
            }       
                          
            exit();
        }

        public function activate($usertype,$username){
            $user = $this->model('User');
            $user->activate($username);
            if($usertype == 'serviceprovider'){
                header("Location: http://localhost/seralance/public/admin/serviceproviders");  
            }
            if($usertype == 'serviceseeker'){
                header("Location: http://localhost/seralance/public/admin/serviceseekers");  
            }                          
            exit();
        }

        public function validateUpdateProfile($input){
            $admin = $this->model('Admin');
            $admin->updateProfile($input);
            header("Location: http://localhost/seralance/public/admin/profile");                
            exit();
        }

        public function validateTicketReply($input){
            $project = $this->model('Ticket');
            $reply = $project->reviewTicket($input);

            if($reply['valid']==true){

                header("Location: http://localhost/seralance/public/admin/closedtickets");              
                exit();
                
            }
            else{
                return $reply;
            }
        }


    }
    
?>