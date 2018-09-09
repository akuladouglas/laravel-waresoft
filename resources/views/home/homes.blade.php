<?php 
/*
This is a sample PHP script of how you would ideally integrate with iPay Payments Gateway and also handling the 
callback from iPay and doing the IPN check

----------------------------------------------------------------------------------------------------
************(A.) INTEGRATING WITH iPAY ***********************************************
----------------------------------------------------------------------------------------------------
*/
//Data needed by iPay a fair share of it obtained from the user from a form e.g email, number etc...
$fields = array("live"=> "0",
                "oid"=> "112",
                "inv"=> "112020102292999",
                "ttl"=> "900",
                "tel"=> "256712375678",
                "eml"=> "kajuej@gmailo.com",
                "vid"=> "demo",
                "curr"=> "KES",
                "p1"=> "airtel",
                "p2"=> "020102292999",
                "p3"=> "",
                "p4"=> "900",
                "cbk"=> $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"],
                "cst"=> "1",
                "crl"=> "2"
                );
/*
----------------------------------------------------------------------------------------------------
************(b.) GENERATING THE HASH PARAMETER FROM THE DATASTRING *********************************
----------------------------------------------------------------------------------------------------

The datastring IS concatenated from the data above
*/
$datastring =  $fields['live'].$fields['oid'].$fields['inv'].$fields['ttl'].$fields['tel'].$fields['eml'].$fields['vid'].$fields['curr'].$fields['p1'].$fields['p2'].$fields['p3'].$fields['p4'].$fields['cbk'].$fields['cst'].$fields['crl'];
$hashkey ="demo";//use "demo" for testing where vid also is set to "demo"

/********************************************************************************************************
* Generating the HashString sample
*/
$generated_hash = hash_hmac('sha1',$datastring , $hashkey);

?>
<!--    Generate the form BELOW   -->
   <form method="post" action="https://payments.ipayafrica.com/v3/ke">

<?php 
 foreach ($fields as $key => $value) {
      echo $key;
     echo '&nbsp;:<input name="'.$key.'" type="text" value="'.$value.'"></br>';
 }
?>hsh:&nbsp;<input name="hsh" type="text" value="<?php echo $generated_hash ?>" ></td>

<button type="submit">&nbsp;Lipa&nbsp;</button>
</form>