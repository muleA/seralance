<?php

    class Dispute extends Model{
        
        private $disputeId;
        private $disputeDate;
        private $status;
        private $explanation;
        private $fileAttachment;
        private $reviewedDate;
        private $decision;


        // --------Getter and Setters of the attributes-----------
        public function getDisputeId(){
            return $this->disputeId; 
        }

        public function setDisputeId($disputeId){
            $this->disputeId = $disputeId;
        }

        public function getDisputeDate(){
            return $this->disputeDate; 
        }

        public function setDisputeDate($disputeDate){
            $this->disputeDate = $disputeDate;
        }

        public function getStatus(){
            return $this->status; 
        }

        public function setStatus($status){
            $this->status = $status;
        }

        public function getExplanation(){
            return $this->explanation; 
        }

        public function setExplanation($explanation){
            $this->explanation = $explanation;
        }

        public function getFileAttachment(){
            return $this->fileAttachment; 
        }

        public function setFileAttachment($fileAttachment){
            $this->fileAttachment = $fileAttachment;
        }

        public function getReviewedDate(){
            return $this->reviewedDate; 
        }

        public function setReviewedDate($reviewedDate){
            $this->reviewedDate = $reviewedDate;
        }

        public function getDecision(){
            return $this->decision; 
        }

        public function setDecision($decision){
            $this->decision = $decision;
        }

        // end of getters and setters

        public function retrieveAllDisputes($username=""){
            require_once('../app/Core/Database.php');
            $db = new Database();
            $conn = $db->setConnection();
            if($conn !== null){
                $sql = "";
                if($_SESSION['usertype']==='serviceseeker' || $_SESSION['usertype']==='serviceprovider'){
                    $sql = "SELECT * FROM dispute where raised_by='".$username."'";
                }
                $stmt = $conn->query($sql);
                if($disputes = $stmt->fetchAll(PDO::FETCH_ASSOC)){
                    return $disputes;
                }
                else{
                    return false;
                }
            }
        }

        public function validateNewDispute($input,$files){
            
            // $disputeData holds the data to be inserted to Service provider table
            $disputeData = array();
            $error=array();
            require_once('../app/models/Project.php');
            $project = new Project();

            $ongoingProjects = [];
            foreach($project->retrieveAllOngoingProjects($_SESSION['username']) as $ongoingproject){
                $ongoingProjects = array_merge($ongoingProjects,array($ongoingproject['project_id']));
            }

            if(empty($input['projectid'])){
                $error = array_merge($error,array('projectid' => 'This field is required.'));
            }
            elseif(!in_array($input['projectid'],$ongoingProjects)){
                $error = array_merge($error,array('projectid' => 'Invalid input.'));
            }            
            else{
                $disputeData = array_merge($disputeData,array('projectid' => $this->cleanInput($input['projectid'])));
            }


            if(empty($input['explanation'])){
                $error = array_merge($error,array('explanation' => 'This field is required.'));
            }
            else{
                $disputeData = array_merge($disputeData,array('explanation' => $this->cleanInput($input['explanation'])));
            }

            if(empty($files['disputefile']['name'])){
                $error = array_merge($error,array('disputefile' => 'This field is required.'));                
            }
            else{
                    $extension = explode('.',$files['disputefile']['name']);
                    $file_ext=strtolower(end($extension));
                    if(!in_array($file_ext,array('jpeg','gif','png','jpg','zip', 'pdf'))){
                        $error = array_merge($error,array('disputefile' => 'JPG, JPEG, PNG, GIF, ZIP and PDF are only supported.'));
                    }
                    elseif($files['disputefile']['size']>2097152){
                        $error = array_merge($error,array('disputefile' => 'File should not be more than 2MB.'));
                    }
                    elseif(empty($error)){
                        $cleanData = 'app/upload/disputes/'.time().$files['disputefile']['name'];
                        move_uploaded_file($files['disputefile']['tmp_name'],"../".$cleanData);
                        $disputeData  = array_merge($disputeData,array('disputefile' => $cleanData));
                    }
            }

            if(empty($error)){
                return array('valid'=>1 ,'data'=>$disputeData);
            }
            else{
                return array('valid'=>0,'data'=>$disputeData,'error'=>$error);
            }
        }

        public function createDispute($data, $files){
            $response = $this->validateNewDispute($data, $files);
            if($response['valid']==true){
                $this->setExplanation($response['data']['explanation']);
                $this->setFileAttachment($response['data']['disputefile']);
                $this->setStatus('open');
                
    
                //The variables below are arguments to be passed to insert data to their respective table 
                $disputeTb = array(
                    'dispute_date' => "UTC_TIMESTAMP",
                    'status' => "'".$this->getStatus()."'",
                    'explanation' => "'".$this->getExplanation()."'",
                    'raised_by' => "'".$_SESSION['username']."'",
                    'file' => "'".$this->getFileAttachment()."'",
                    'project_id' => "'".$response['data']['projectid']."'"
                );

                $this->insert('dispute',$disputeTb);
                return array('valid'=>1);
            } 
            else{
                return $response;
            }      
        }

    }
?>