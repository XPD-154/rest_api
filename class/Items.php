<?php
class Items{

    private $itemsTable = "visitor_activity_logs";  //table containing data to be retrieved
    private $keyTable = "prclient";					//table containing authentication key
    public $key;									//variable for auth key
    public $id;										//variable for data retrieval
    public $user_ip_address;
    public $user_agent;
    public $page_url;
    public $referrer_url;
    public $user;
	public $message;
	public $project;
    private $conn;

    //class constructor
    public function __construct($db){
        $this->conn = $db;
    }

    //method for authentication
    function auth(){
    	if($this->key){
    		$query="SELECT * FROM ".$this->keyTable." WHERE CLuniqueId = :CLuniqueId";
			$sql=$this->conn->prepare($query);
			$sql->execute(array(':CLuniqueId'=>$this->key));
    	}
    	$result=$sql->fetchAll(PDO::FETCH_ASSOC);
		return $result;
    }

    //method for retriving data
	function read(){
		if($this->id) {
			$query="SELECT * FROM ".$this->itemsTable." WHERE id = :id";
			$sql=$this->conn->prepare($query);
			$sql->execute(array(':id'=>$this->id));

		} else {
			$query="SELECT * FROM ".$this->itemsTable;
			$sql=$this->conn->prepare($query);
			$sql->execute();
		}
		$result=$sql->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

    //method for creating data
	function create(){

		$this->user_ip_address = htmlspecialchars(strip_tags($this->user_ip_address));
		$this->user_agent = htmlspecialchars(strip_tags($this->user_agent));
		$this->page_url = htmlspecialchars(strip_tags($this->page_url));
		$this->referrer_url = htmlspecialchars(strip_tags($this->referrer_url));
		$this->user = htmlspecialchars(strip_tags($this->user));
		$this->message = htmlspecialchars(strip_tags($this->message));
		$this->project = htmlspecialchars(strip_tags($this->project));

		$query = "INSERT INTO ".$this->itemsTable."(user_ip_address, user_agent, page_url, referrer_url, user, message, project) VALUES (:user_ip_address, :user_agent, :user_current_url, :referrer_url, :user, :message, :project)";

		$sql=$this->conn->prepare($query);
		$sql->execute(array(':user_ip_address'=>$this->user_ip_address,
							':user_agent'=>$this->user_agent,
							':user_current_url'=>$this->page_url,
							':referrer_url'=>$this->referrer_url,
							':user'=>$this->user,
							':message'=>$this->message,
							':project'=>$this->project));

		if($sql){
			return true;
		}

		return false;
	}

    //method for updating data
	function update(){

		$this->id = htmlspecialchars(strip_tags($this->id));
		$this->user_ip_address = htmlspecialchars(strip_tags($this->user_ip_address));
		$this->user_agent = htmlspecialchars(strip_tags($this->user_agent));
		$this->page_url = htmlspecialchars(strip_tags($this->page_url));
		$this->referrer_url = htmlspecialchars(strip_tags($this->referrer_url));
		$this->user = htmlspecialchars(strip_tags($this->user));
		$this->message = htmlspecialchars(strip_tags($this->message));
		$this->project = htmlspecialchars(strip_tags($this->project));

		$query="UPDATE ".$this->itemsTable." SET user_ip_address = :user_ip_address,
												 user_agent = :user_agent,
												 page_url = :page_url,
												 referrer_url = :referrer_url,
												 user = :user,
												 message = :message,
												 project = :project
												 WHERE id = :id";

        $sql=$this->conn->prepare($query);
		$sql->execute(array(':id'=>$this->id,
							':user_ip_address'=>$this->user_ip_address,
							':user_agent'=>$this->user_agent,
							':page_url'=>$this->page_url,
							':referrer_url'=>$this->referrer_url,
							':user'=>$this->user,
							':message'=>$this->message,
							':project'=>$this->project));

		if($sql){
			return true;
		}

		return false;
	}

    //method for deleting data
	function delete(){

		$this->id = htmlspecialchars(strip_tags($this->id));

		$query="DELETE FROM ".$this->itemsTable." WHERE id = :id";
		$sql=$this->conn->prepare($query);
		$sql->execute(array(':id'=>$this->id));

		if($sql){
			return true;
		}

		return false;

	}
}
?>
