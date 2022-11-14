<?php


echo "Welcome to Automated Car Parking System."."\n";
echo "Please provide the filename for configuration.\n Ensure that the file exists in same folder executing the script.\n the system will accept .txt files only. avoid space in filename. instead use _ for space"."\n";
echo "\n the file contents can be set like this\n create 7     :for setting the parking pool\n park HR-26SS-5433     : For parking a car\n";
echo "leave HR-26FF-555      : for unpark a car\n status      : for seeing the current status\n";
echo "press Ctrl + c to exit the program\n";
$sz='';
$fileinput='';
$szarr=array();
$tmarr=array();

startfun();

//mainfun();

function startfun(){
    echo "Input 1 to use the program with file input and 2 to control with direct cmd and 0 to exit\n";
    $sinput=readline("Enter 1 or 2 or 0: ");
    if($sinput=='1'){
    mainfun();
    }elseif($sinput=='2'){
        mainfun1();
    }
    elseif($sinput=='0'){
        exit;
    }
    else{
        echo "Please input 1 or 2 only\n";
        startfun();
    }
}


function takeinput(){
    global $fileinput;
    $fileinput=readline("Enter the filename: ");
if(substr($fileinput,-4)!='.txt'){
echo "please give file name in .txt format"."\n";
takeinput();
}
if ( !file_exists($fileinput) ) {
    echo ('File not found.'."\n");
  
takeinput();
}
}



function mainfun(){
global $sz;
global $fileinput;
global $tmarr;
global $szarr;
takeinput();
$input = fopen($fileinput, "r");
  
while(!feof($input)) {
   $action='';
    $line=fgets($input);
    $line=$line;
    //echo $line;
    $exp=explode(' ',$line);
    $action=trim($exp[0]);
    //echo $action; //exit;
    switch($action){
        case 'create':
                if($sz!=''){ echo "Parking lot already created\n"; }
                else{
                    $sz=$exp[1];
                    echo "Created parking lot with size $sz"."\n";
                }
            break;
        case 'park':
                $srch=false;
                $exp[1]=trim($exp[1]);
                if(is_array($szarr)){
                $srch=array_search($exp[1], $szarr);
                //echo $srch."\n"; exit;
                 }
                 if($srch!=false){ 
                     echo "car Reg No $exp[1] already in parking in slot $srch.\n";}
                elseif(is_array($szarr) && count($szarr)==$sz){ echo "Sorry parking is full.\n"; }
                elseif($sz==''){ echo "please create parking lot first.\n";}
                
                else{
                    $alotind=1;
                    if(is_array($szarr) && count($szarr)> 0){
                        for($i=1; $i<=$sz; $i++){
                            if (array_key_exists($i, $szarr)){
                                continue;
                            }else{
                                $alotind=$i;
                                break;
                            }
                        }
                    
                         }
                    $szarr[$alotind]=$exp[1];
                    $tmarr[$exp[1]]=date("Y-m-d H:i:s");
                    //$tmarr[$exp[1]]="2022-11-13 09:00:11";
                    echo "Car Reg No $exp[1] parked in slot $alotind.\n";

                }


            break;
        case 'leave':
          
           $exp[1]=trim($exp[1]);
            $srch1=false;
                if(is_array($szarr)){
                $srch1=array_search($exp[1], $szarr);
                
                 }
                
                 if(is_array($szarr) && $srch1!=false){ 
                    $from_time = strtotime($tmarr[$exp[1]]); 
                    $date1=date("Y-m-d H:i:s");
                    //$date1='2022-11-13 13:34:33';
                    $to_time = strtotime($date1); 
                     $diff_minutes = round(abs($from_time - $to_time) / 60,2);
                    $hour=ceil((float)$diff_minutes/60);
                    if($hour > 2){ $charge=(10*$hour)-10;}
                    else{ $charge=10;}
                    unset($szarr[$srch1]);
                   unset($tmarr[$exp[1]]);
                 echo "Car Reg No $exp[1] left with charge $charge.\n";
                 }elseif(is_array($szarr) && $srch1==false){
                    echo "Car Reg No $exp[1] not found in parking\n";
                 }elseif(!is_array($szarr)){ echo "please create the parking lot first\n";}
            break;
        case 'status':
            if(is_array($szarr) && count($szarr) > 0){
                echo "Slot No.\tRegistration No.\n";
                ksort($szarr);
                foreach($szarr as $key=>$val){
                    echo $key."        \t".$val."\n";
                }
            }
            elseif($sz==''){ echo "parking lot not exists.\n";}
            else{
                echo "Parking is empty and avaulable for use.\n";
            }
            break;
        default:
            echo "please give valid input.\n";

    }
}
mainfun();
}


function takeinput1(){
    //global $fileinput;
    $input=readline("Enter the cmd: ");
    return $input;

}



function mainfun1(){
    global $sz;
    global $fileinput;
    global $tmarr;
    global $szarr;
    //takeinput1();
    // $input = fopen($fileinput, "r");
      
    // while(!feof($input)) {
       $action='';
        $line=takeinput1();
        $exp=explode(' ',$line);
        $action=trim($exp[0]);
        //echo $action; //exit;
        switch($action){
            case 'create':
                    if($sz!=''){ echo "Parking lot already created\n"; }
                    else{
                        $sz=$exp[1];
                        echo "Created parking lot with size $sz"."\n";
                    }
                break;
            case 'park':
                    $srch=false;
                    $exp[1]=trim($exp[1]);
                    if(is_array($szarr)){
                    $srch=array_search($exp[1], $szarr);
                    //echo $srch."\n"; exit;
                     }
                     if($srch!=false){ 
                         echo "car Reg No $exp[1] already in parking in slot $srch.\n";}
                    elseif(is_array($szarr) && count($szarr)==$sz){ echo "Sorry parking is full.\n"; }
                    elseif($sz==''){ echo "please create parking lot first.\n";}
                    
                    else{
                        $alotind=1;
                        if(is_array($szarr) && count($szarr)> 0){
                            for($i=1; $i<=$sz; $i++){
                                if (array_key_exists($i, $szarr)){
                                    continue;
                                }else{
                                    $alotind=$i;
                                    break;
                                }
                            }
                        
                             }
                        $szarr[$alotind]=$exp[1];
                        $tmarr[$exp[1]]=date("Y-m-d H:i:s");
                        //$tmarr[$exp[1]]="2022-11-13 09:00:11";
                        echo "Car Reg No $exp[1] parked in slot $alotind.\n";
    
                    }
    
    
                break;
            case 'leave':
              
               $exp[1]=trim($exp[1]);
                $srch1=false;
                    if(is_array($szarr)){
                    $srch1=array_search($exp[1], $szarr);
                    
                     }
                    
                     if(is_array($szarr) && $srch1!=false){ 
                        $from_time = strtotime($tmarr[$exp[1]]); 
                        $date1=date("Y-m-d H:i:s");
                        //$date1='2022-11-13 13:34:33';
                        $to_time = strtotime($date1); 
                         $diff_minutes = round(abs($from_time - $to_time) / 60,2);
                        $hour=ceil((float)$diff_minutes/60);
                        if($hour > 2){ $charge=(10*$hour)-10;}
                        else{ $charge=10;}
                        unset($szarr[$srch1]);
                       unset($tmarr[$exp[1]]);
                     echo "Car Reg No $exp[1] left with charge $charge.\n";
                     }elseif(is_array($szarr) && $srch1==false){
                        echo "Car Reg No $exp[1] not found in parking\n";
                     }elseif(!is_array($szarr)){ echo "please create the parking lot first\n";}
                break;
            case 'status':
                if(is_array($szarr) && count($szarr) > 0){
                    echo "Slot No.\tRegistration No.\n";
                    ksort($szarr);
                    foreach($szarr as $key=>$val){
                        echo $key."        \t".$val."\n";
                    }
                }
                elseif($sz==''){ echo "parking lot not exists.\n";}
                else{
                    echo "Parking is empty and avaulable for use.\n";
                }
                break;
            default:
                echo "please give valid input.\n";
    
        }
    
    mainfun1();
    }
    


?>