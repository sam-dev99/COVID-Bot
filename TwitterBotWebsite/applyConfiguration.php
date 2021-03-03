<?php
    session_start();
    
    if(isset($_SESSION['S_user']))
    {
        require_once 'db_include.php';
        
        $conn = OpenCon();
        
        if($conn)
        {
            // if(isset($_POST['deploy']))
            // {
                if(isset($_POST['Apply'])){//to run PHP script on submit
                    
                    if($_POST['custom'] != "")
                    {
                        $random = $incremental = $decremental = 0;
                    }
                    else{
                         if(isset($_POST['priority'])){
                            $val = $_POST['priority'];
                            if($val == "random"){
                                $random = 1;
                                $incremental = 0;
                                $decremental = 0;
                            }
        
                            if($val == "incremental"){
                                $random = 0;
                                $incremental = 1;
                                $decremental = 0;
                            }
                            
                            if($val == "decremental"){
                                $random = 0;
                                $incremental = 0;
                                $decremental = 1;
                            }
                        }
                        else{
                            $random = $incremental = $decremental = 0;
                        }
                    }
                    
                    if(!empty($_POST['deploy'])){
                        $deploy = 1;
                    }
                    else{
                        $deploy = 0;
                    }
                    
                }
                
                //change all deploy to 0 and set the current one to 1;
                if($deploy == 1)
                {
                    $query = "update fileconfig set deploy = '0' where deploy = '1'";
                    $conn->query($query);
                }
                
                $query = "update fileconfig set 
            title = '" . $conn->real_escape_string($_POST['title']) . "',
            topic = '" . $conn->real_escape_string($_POST['topic'])  . "',
            hashtag = '" . $conn->real_escape_string($_POST['hashtag']) . "',
            customized = '" . $conn->real_escape_string($_POST['custom']) . "',
            tweetsperconfig = '" . $conn->real_escape_string($_POST['tweetsperconfig']) . "',
            tweetsperhour = '" . $conn->real_escape_string($_POST['tweetsperhour']) . "',
            random = '" . $random . "',
            incremental = '" . $incremental . "',
            decremental = '" . $decremental . "',
            deploy = '" . $deploy . "'
                            
                    where ID = '" . $conn->real_escape_string($_POST['id']) . "'";
                            
                $result = $conn->query($query);

                $hashtag = $conn->real_escape_string($_POST['hashtag']);
                $topic = $conn->real_escape_string($_POST['topic']);

                if($hashtag != NULL && $topic != NULL){
                    //reset hashtags
                    $reset_query = "update tweet_topic set hashtag = NULL";
                    $conn->query($reset_query);

                    //update tweets table to have the new hashtag set to the new topic and reset everything else.
                    $update_hashtags = "update tweet_topic set hashtag='".$hashtag."' where topic='".$topic."'";
                    $conn->query($update_hashtags);

                }
                
                  $URL="configure.php?";
                    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
            // }

        }
        
        $conn->close();
    }
?>