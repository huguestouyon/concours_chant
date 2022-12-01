<?php
include('includes/header.php');
// $url = "https://shazam.p.rapidapi.com/auto-complete?term=".str_replace(' ', '+',$_POST['music'])."&locale=fr-FR";
// $curl = curl_init();

// curl_setopt_array($curl, [
// 	CURLOPT_URL => $url,
// 	CURLOPT_RETURNTRANSFER => true,
// 	CURLOPT_FOLLOWLOCATION => true,
// 	CURLOPT_ENCODING => "",
// 	CURLOPT_MAXREDIRS => 10,
// 	CURLOPT_TIMEOUT => 30,
// 	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
// 	CURLOPT_CUSTOMREQUEST => "GET",
// 	CURLOPT_HTTPHEADER => [
// 		"X-RapidAPI-Host: shazam.p.rapidapi.com",
// 		"X-RapidAPI-Key: 0765394f0amsh8eb909d1b3c6247p145d55jsnee4ff1c1e231"
// 	],
// ]);

// $response = curl_exec($curl);
// $parsee=json_decode(curl_exec($curl), true);
// $err = curl_error($curl);

// curl_close($curl);

// if ($err) {
// 	echo "cURL Error #:" . $err;
// }
?>

<label for="autocomplete">Select a programming language: </label>
    <input id="autocomplete">
    <script>
    // console.log(document.getElementById('autocomplete').value
    // console.log(variable)
    input = document.querySelector("input");
    input.addEventListener('#input', () => {
        console.log(input.values)
    })
    // console.log(document.querySelector("#text").values)
    // var val_rechercher="";
    // function update_val(){
    //     val_rechercher=document.querySelector('input').value;
    // }
    //     console.log(val_rechercher)
    //     let input = document.querySelector('input').value;
    //     console.log(input)
        const settings = {
        "async": true,
        "crossDomain": true,
        "url": "https://shazam.p.rapidapi.com/auto-complete?term=booba&locale=fr_FR",
        //"url": "https://shazam.p.rapidapi.com/auto-complete?term="+booba+"&locale=fr_FR",
        "method": "GET",
        "headers": {
            "X-RapidAPI-Key": "ed3ed5bec9mshcb4fa77058cfd9ep1fbc89jsn771de5eb28e9",
            "X-RapidAPI-Host": "shazam.p.rapidapi.com"
        }
    };
    let tab = []
    let rep = '';
    let test = [];
    let responseTest = [];


    $.ajax(settings).done(function (response) {
        rep = response.hints;
        //console.log(rep)
        // tab = tab.push(response.hints)
        // console.log(tab)
        //console.log(rep)
        // for (let i = 0; i < array.length; i++) {
        //     const element = array[i];
            
        // }
        test = Object.values(rep)
        test.forEach(element => {
            //console.log(element.term);
            responseTest.push(element.term);
        });
        console.log(responseTest);
        
        //console.log(test[0].term)
        // for (let i = 0; i < array.test; i++) {
        //     console.log(test[i].term);
        // }
        
        $( "#autocomplete" ).autocomplete({
        // source: [ "c++", "java", "php", "coldfusion", "javascript", "asp", "ruby" ]
        source: responseTest
    });
    });
    // rep.forEach(element => {
    //         console.log(element)
    //     });
    // $( "#autocomplete" ).autocomplete({
    //     // source: [ "c++", "java", "php", "coldfusion", "javascript", "asp", "ruby" ]
    //     //
    // });


    </script>
    
</body>
</html>