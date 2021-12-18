<?php 
    include '../../koneksi.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Dropdown Ajax</title>
    </head>
    <body>
        <div class="country">
            <label>Country</label>
            <select name="country" onchange="getId(this.value);">
                <option value="">Select Country</option>
                //populate value using php
                <?php
                    $query1 = "SELECT * FROM msprovinsi";
                    $results1=mysqli_query($koneksi, $query1);
                    //loop
                    foreach ($results1 as $country){
                ?>
                        <option value="<?php echo $country["ID_Provinsi"];?>"><?php echo $country["NamaProvinsi"];?></option>
                <?php
                    }
                ?>
            </select>
        </div>
    
        <div class="city">
            <label>City</label>
            <select name="city" id="cityList" onchange="getId(this.value);">
                <option value="">Select City</option>
                <?php
                    if (!empty($_POST["ID_Provinsi"])) {
                        $cid = $_POST["ID_Provinsi"]; 
                        $query2="SELECT * FROM mskabkota WHERE ID_Provinsi=$cid";
                        $results2 = mysqli_query($koneksi, $query2);

                        foreach ($results2 as $city){
                ?>
                            <option value="<?php echo $city["ID_KabKota"];?>"><?php echo $city["NamaKabKota"];?></option>       
                <?php
                        }
                    }
                ?>  
            </select>
        </div>
    <script   src="https://code.jquery.com/jquery-3.1.1.js"   integrity="sha256-
16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA="   crossorigin="anonymous">  
    </script>
    <script>
        function getId(val){
            //We create ajax function
            $.ajax({
                type: "POST",
                url: "getdata.php",
                data: "ID_Provinsi="+val,
                success: function(data){
                    $("#cityList").html(data);
                }
            });
        }
    </script>
    </body>
</html>