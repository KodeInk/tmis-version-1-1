<?php

/**
 * This class processes CSV, MS Excel and text files for contacs
 * SOME FUNCTIONS WERE TRANSFERED DIRECTLY FROM THE OLD CLOUT SYSTEM
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.1.0
 * @copyright Clout
 * @created 03/07/2013
 */
class Csv_account_processor extends CI_Model
{
	#Description Variable to hold file content for CSV upload contacts
    private $fileContent;
    #Description Variable to store parsed email ids from different sources
    private $data=array();
    #Description To hold intermediate Type value for CSV uploads
    private $format;
    #Description Number of insert commands at a time, this value will be used while inserting contacts into
    #user_contacts table
    private $maxInserts;
	#Current user id
    private $userId;
	#THe location of the file
	private $fileLocation;
	
	
    function __construct()
    {
        parent::__construct();
        #Set number of max insert commands at a time.
        $this->maxInserts = MAX_EMAIL_BATCH_COUNT;
    }
	
	
	#Get contacts from upload csv files. Saves file contents in $this->filecontent variable and parse email ids
    #from that string depends upon the format specified. After parsing email ids (Name and Email), eliminates
    #duplicates, inserts in imported_contacts table for the user and returns an array with "Mail Type" and "Number of Contacts"
    #to the caller routine for further processing
    public function get_contacts_through_file($userId, $fileLocation,$format)
    {
        #Save user contact in local variable
        $this->userId = $userId;
        #Get contents only if the file exists
        if(!empty($fileLocation))
        {
            #Save file contents into a local variable without saving the file in another location
            $this->filecontent = remove_quotes(preg_replace("/[\r]/","",file_get_contents($fileLocation))); 
			$this->fileLocation = $fileLocation;
        }
		
        #Save format in local variable
        $this->format=$format;
        #Parse contacts
        $this->get_contacts_from_file();
        #Check and remove duplicate email ids
        $this->check_dup_emailids();
        #Insert in user_contacts table
        $this->insert_user_contacts();
        #Return Contacts data to caller for displaying to user to select
        if($this->filecontent=="" && count($this->data)==0)
		{
            return array("result" =>FALSE, "message"=>"No Data found in Input");
		}
		else if($this->filecontent!="" && count($this->data)==0)
        {
			return array("result" =>FALSE, "message"=>"Invalid data");
		}
		else
		{
            #DO not show @linkedin.com email addresses because the user can not resend using them.
			$saved_contacts = $this->db->query($this->query_reader->get_query_by_code('get_imported_contacts', array('condition'=>" AND C.owner_user_id='".$this->userId."' AND C.email_address NOT LIKE '%@linkedin.com' ", 'limit_text'=>"", 'min_send_cycle'=>MIN_SEND_CYCLE)))->result_array();
			return array("result" =>TRUE, "message"=>"", "data"=>$saved_contacts);
		}
    }
	
	
	
	#This is a private function of this class. This function decides which function should be called
    #to parse the file content depending upon the format specified.
    private function get_contacts_from_file()
    {
        switch($this->format)
        {
            case 'csv_generic': #Generic CSV
                $this->parse_csv_sep(",");
                break;
            case 'csv_yahoo': #Yahoo Contacts CSV
                $this->parse_csv_yahoo();
                break;            
            case 'csv_gmail': #Gmail Contacts CSV
                $this->parse_csv_gmail();
                break;
            case 'csv_hotmail': #Hotmail Contacts CSV
                $this->parse_csv_hotmail();
                break;
            case 'csv_aol': #AOL Contacts CSV
                $this->parse_csv_aol();
                break;
            case 'csv_thunderbird': #ThunderBird contacts format
                $this->parse_csv_thunder();
                break;
            case 'text_commas': #Text format contacts CSV
                $this->parse_csv_text();
                break;
            case 'text_tabs': #Tab delimited Contacts CSV
                $this->parse_csv_sep("\t");
                break;            
            case 'csv_outlook': #Outlook contacts CSV
            	$this->parse_csv_outlook();
                break;
        }        
    }
	
	
	
	
	#This is a private function of this class. This function parse email ids from a plain text file
    #with comma separator and store these email ids in this class data array
    private function parse_csv_text()
    {
        // Exit function if file content is null
        if(empty($this->filecontent))
            return;
        else
        {
            //As this is function expects all email ids with comma seperation, lets remove new line 
            //and carriege return characters from content and explode the content with ",". 
            //So that will will get only email ids
            $emailids=explode(",",trim(preg_replace("/[\n\r\s+]/","",$this->filecontent)));
            //Get the number of contacts found
            $cnt=count($emailids);
            for($i=0; $i < $cnt; $i++) // Loop through all email ids and store them in data array
                $this->data[]=array("name"=>"","email"=>$emailids[$i]);
        }
    }
	
	
	
	
    #This is a private function of this class. This function parse email ids from a csv file with specific
    #seperator i.e, ",", or "/t" (tab) separator and store these email ids in this class data array.
    #As this is a csv file, it will have both name and email id
    private function parse_csv_sep($sep)
    {
        // exit function if file content is null
        if(empty($this->filecontent))
            return;
        else
        {
            // Explode the file content with new line to get number of contacts
            $emails = explode("\n",$this->filecontent);
            $cnt = count($emails);
            for($i=0; $i < $cnt; $i++) // Loop through all entries
            {
                //Explode each entry with given seperator i.e, "," or "tab"
                $data=explode($sep,$emails[$i]);
                if(count($data)<2 || !strpos($data[1],"@")) // if number of fields in entry are less than 2 or there is no "@" in second field (Might be Column headings), move to next entry
                    continue;
                //Save email info in data array
                $this->data[] = array("name"=>$data[0],"email"=>$data[1]);
            }
        }
    }
	
	
	
	#This is a private function of this class. This function parse email ids from Yahoo Import contacts CSV.
    #This CSV will have upto 56 fields in each row. Yahoo email can be found in 5th column.
    private function parse_csv_yahoo()
    {
        // exit function if file content is null
        if(empty($this->filecontent))
            return;
        else
        {
            // Explode the file content with new line to get number of contacts
            $emails = explode("\n",$this->filecontent);
            $cnt = count($emails);
            //Start with 1 as first row will be Column Titles
            for($i=1; $i < $cnt; $i++) // Loop through all entries
            {
                // Explode the row with ","
                $temp=explode(",",$emails[$i]);
                if(count($temp) < 50)
                    continue;
                //Yahoo name will be found in column1 (First Name), column2 (Middle Name) and column3 (Last Name)
                $username = trim($temp[0]).' '.trim($temp[1]).' '.trim($temp[2]);
                $emailid= trim($temp[4]); // Email id can be found in column 5
                if($emailid=="")
                {
                    //If email id is not found in column 5 try below fileds for alternate email id
                    if(trim($temp[7])!="") // Yahoo Messenger ID
                    {
                        if(check_email_address($temp[7]))
                            $emailid = $temp[7];
                        else
                            $emailid = $temp[7]."yahoo.com";
                    }
                    else if(trim($temp[50])!="") //ICQ ID
                        $emailid = trim($temp[50]);                    
                    else if(trim($temp[51])!="") //Google ID
                        $emailid = trim($temp[51]);                    
                    else if(trim($temp[52])!="") //MSN ID
                        $emailid = trim($temp[52]);                    
                    else if(trim($temp[53])!="") //AIM ID
                        $emailid = trim($temp[55]);
                }
                //Save email info in data array
                $this->data[]=array("name"=>$username,"email"=>$emailid);
            }
        }
    }
    
	
	
	#This is a private function of this class. This function parse email ids from Gmail Import contacts CSV.
    #This CSV will have upto 28 fields in each row. Gmail email can be found in 29th column.
    private function parse_csv_gmail()
    {
        // exit function if file content is null
        if(empty($this->filecontent))
            return;
        else
        {
            // Explode the file content with new line to get number of contacts
            $emails = explode("\n",$this->filecontent);
            $cnt = count($emails);
            //Start with 1 as first row will be Column Titles
            for($i=1; $i < $cnt; $i++)
            {
                // Explode the row with ","
                $temp=explode(",",$emails[$i]);
                if(count($temp) < 28)
                    continue;
                //Gmail name can be found in column1 (Name)
                $username = trim($temp[0]);
                //Gmail Email ID can be found in 29th column
                $emailid= trim($temp[28]);
                $this->data[]=array("name"=>$username,"email"=>$emailid);
            }
        }
    }
   
	
	
	#This is a private function of this class. This function parse email ids from Hotmail/MSN Import 
    #contacts CSV. This CSV will have morethan 52 fields in each row. email can be found in 47th column.
    private function parse_csv_hotmail()
    {
        // exit function if file content is null
        if(empty($this->filecontent))
            return;
        else
        {
            // Explode the file content with new line to get number of contacts
            $emails = explode("\n",$this->filecontent);
            $cnt = count($emails);
            //Start with 1 as first row will be Column Titles
            for($i=1; $i < $cnt; $i++)
            {
                // Explode the row with ","
                $temp=explode(",",$emails[$i]);
                if(count($temp) < 51)
                    continue;
                $username = "";
                $emailid= trim($temp[46]);
                if($emailid=="")
                {
                    //If email id not found in 47 filed, try below fields
                    if(trim($temp[49])!="") //ICQ ID
                        $emailid = trim($temp[49]);                    
                    else if(trim($temp[51])!="") //Google ID
                        $emailid = trim($temp[51]);
                }
                $this->data[]=array("name"=>$username,"email"=>$emailid);
            }
        }
    }
    
	
	
	#This is a private function of this class. This function parse email ids from AOL/AIM Import contacts CSV.
    #This CSV will have morethan 5 fields in each row. email can be found in 5th column.
    private function parse_csv_aol()
    {
        // exit function if file content is null
        if(empty($this->filecontent))
            return;
        else
        {
            // Explode the file content with new line to get number of contacts
            $emails = explode("\n",$this->filecontent);
            $cnt = count($emails);
            //Start with 1 as first row will be Column Titles
            for($i=1; $i < $cnt; $i++)
            {                
                // Explode the row with ","
                $temp=explode(",",$emails[$i]);
                if(count($temp) < 4)
                    continue;
                $username = ""; //Name field cant find in this type of csv
                $emailid= trim($temp[4]);
                if($emailid=="")
                        $emailid = trim($temp[5]);
                    $this->data[]=array("name"=>$username,"email"=>$emailid);
            }
        }
    }
    
	
	
	#This is a private function of this class. This function parse email ids from Thunderbird email client 
    #contacts CSV. This CSV will have morethan 5 fields in each row. email can be found in 5th column.
    private function parse_csv_thunder()
    {
        // exit function if file content is null
        if(empty($this->filecontent))
            return;
        else
        {
            // Explode the file content with new line to get number of contacts
            $emails = explode("\n",$this->filecontent);
            $cnt = count($emails);
            //Start with 1 as first row will be Column Titles
            for($i=1; $i < $cnt; $i++)
            {
                // Explode the row with ","
                $temp=explode(",",$emails[$i]);
                $username = ""; //Name field cant find in this type of csv
                $emailid= trim($temp[4]);
                    $this->data[]=array("name"=>$username,"email"=>$emailid);
            }
        }
    }
    
	
	
	#This is a private function of this class. This function parse email ids from Microsoft Outlook email client 
    #contacts CSV. This CSV will have morethan 20 fields in each row. Field values will be decided depending
    #upon column names
    private function parse_csv_outlook()
    {
        // exit function if file content is null
        if(empty($this->filecontent))
            return;
        else
        {
            // Explode the file content with new line to get number of contacts
            $emails = explode("\n",$this->filecontent);
            $cnt = count($emails);
            /*
             * Name filed is different with different versions of outlook contacts csv file. In some versions,
             * name can be found under "Name" filed and some versions name is split into 3 columns "First Name",
             * "Middle Name" and "Last Name". So, we need to decide what is the field for name and email. While
             * traversing the contacts, we can simply use the id for particular value.
             */
            //Variable to hold "Name" filed index
            $name_id="";
            //Variable to hold column name for "Name" filed
            $name_id_field="NAME";
            //Variable to hold "Name" filed index
            $email_id="";
            //Get number of columns available in each contact row
            $column_numbers=explode(",",$emails[0]);
            //Loop through all columns of first row (Columns Headers) and finalize name filed and email id field
            for($i=0; $i < count($column_numbers); $i++)
            {
                if(strtoupper(trim($column_numbers[$i]))=="E-MAIL ADDRESS")
                    $email_id = $i;                
                if(strtoupper(trim($column_numbers[$i]))=="NAME")
                    $name_id = $i;                
                if(strtoupper(trim($column_numbers[$i]))=="FIRST NAME")
                {
                    $name_id = $i;
                    $name_id_field = "FIRST NAME";
                }
                
            }           
            //Start with 1 as first row will be Column Titles
            for($i=1; $i < $cnt; $i++)
            {
                // Explode the row with ","
                $temp=explode(",",$emails[$i]);
                // Some rows might not have the name and email id values, in that case go to next record
                if(count($temp) < 20)
                    continue;
                if($name_id_field=="NAME")
                    $username = trim($temp[$name_id]);
                else
                    $username = trim($temp[$name_id]." ".$temp[$name_id+1]." ".$temp[$name_id+2]);
                $emailid= trim($temp[$email_id]);
                if($emailid=="")
                        $emailid = trim($temp[5]);
                    $this->data[]=array("name"=>$username,"email"=>$emailid);
            }
        }
    }
	
	
	
	
	#This is a private function of this class. This function clears the data array of email ids.
    #Some entries might not have Name values and some entries might not be real email ids.
    #This function will take care of these points.
    private function clear_data_array()
    {
        //Copy all email ids into temp variable
        $temp=$this->data;
        //Empty Email ids data array
        $this->data=array();
        //Get total number of email contacts available in temp variable
        $cnt=count($temp);
        for($i=0; $i < $cnt; $i++) //Loop through available email contacts
        {
            //Store email id in data array if already not exist in that
            if(filter_var($temp[$i]["email"], FILTER_VALIDATE_EMAIL))
            {
                $temp[$i]["email"] = strtolower(trim(preg_replace('/[\x00-\x09\x0B-\x19\x7F]/', '', $temp[$i]["email"])));
                if(trim($temp[$i]["name"])=="")
                {
                    $temp1 = explode("@",$temp[$i]["email"]);
                    $temp[$i]["name"] = trim($temp1[0]);
                }
                $this->data[]=$temp[$i];
            }
        }
    }
	
	
	
	
	#This is a private function of this class. This function makes email id's data array unique
    #i.e, removes duplicate entries and restore in this class data variable
    private function check_dup_emailids()
    {
        //Clear the email data first
        $this->clear_data_array();
        //Copy all email ids into temp variable
        $temp=$this->data;
        //Empty Email ids data array
        $this->data=array();
        //Get total number of email contacts available in temp variable
        $cnt=count($temp);
        for($i=0; $i < $cnt; $i++) //Loop through available email contacts
        {
            //Store email id in data array if already not exist in that
            if(!in_array($temp[$i],$this->data) && filter_var($temp[$i]["email"], FILTER_VALIDATE_EMAIL))
                    $this->data[]=$temp[$i];
        }
    } 
	
	
	#This function saves the contact email ids information in database along with the type (source) of the contacts. 
	#Here we use "replace" instead of "insert" to avoid duplicate email ids / query failure due to assigned constraint 
	#to this table. Number of  rows that can be sent to database is also configured with a private variable.
    private function insert_user_contacts()
    {
        //Get total number of contacts
        $cnt = count($this->data);    
		# Proceed if data array has any contacts    
        if($cnt > 0) 
        {
            //Local variable to carry number of contacts sent to database till a perticular iteration and this
            //variable decides when the query to be sent to database.
            $num_inserted=0;
			$insert_batch_no =50;
			
            //Starting of the replace query
            $query_start = $query = $this->query_reader->get_query_by_code('insert_batch_contacts');
			
            for($i=0; $i < $cnt; $i++) //Loop through all contacts
            {
                //If counter is successfully divisible by configured inserts?, OK!
                if($num_inserted!=0 && ($num_inserted % $insert_batch_no) == 0)
                {
                    //Remove trailing "," from insert query
                    $query = trim($query,",");
                    // Send to database
                    $this->db->query($query);
                    //Re-initilize the insert query
                    $query=$query_start;
                }
				#Attempt to generate the name from the obtained strings
				$name = explode(' ', $this->data[$i]["name"]);
				$first_name = (is_array($name) && count($name)>0)? addslashes($name[0]): '';
				$middle_name = (is_array($name) && count($name)>2)? addslashes($name[1]): '';
				$last_name = (is_array($name) && count($name)>1)? addslashes(end($name)): '';
                //compute an insert values string with appropriate values, dont forget to add "," at the end of
                //string
                $query .="('".$this->native_session->get('userId')."', '".$first_name."', '".$middle_name."', '".$last_name."', '', '".$this->data[$i]["email"]."', '".$this->fileLocation."', '', NOW()),";
                //Update the value of num_inserted
                $num_inserted++;
            }
            /**
             * Wait, insertion is not yet completed. as per above logic, query will be sent to database 
             * for every "num_inserts" rows. What if the total of contacts is not divisible by "num_inserts" 
             * value or number of contacts are lessthan "num_inserts" value?
             * 
             * Got it?
             * Check the same and send the query to database if needed
             */
            if($num_inserted!=0 && ($num_inserted % $insert_batch_no) != 0)
            {
                $query = trim($query,",");
                $this->db->query($query);
            }
        }
    }
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}


?>