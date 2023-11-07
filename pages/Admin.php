<!--traveler--123456-->
<?php
if (!isset($_SESSION['radmin'])) {
    echo "<h3/><span style='color:red;'>For Administrators Only!</span><h3/>";
    exit();
}
$mysql = connect();

?>
<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-6 left">
        <!-- Countries form -->
        <?php
        $columns = 'SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = "travelbase" AND TABLE_NAME = "countries" ORDER BY ORDINAL_POSITION;';
        $res_col = mysqli_query($mysql, $columns);
        $col_name = mysqli_fetch_all($res_col, MYSQLI_NUM);

        $sel = 'SELECT * FROM countries ORDER BY id';
        $res = mysqli_query($mysql, $sel);
        ?>

        <form action="index.php?page=4" method="post" class="input-group" id="formcountry">
            <p>Countries</p>
            <table class="table table-striped">
                <tr>
                    <?php
                    foreach ($col_name as $name) {
                        echo '<th>' . $name[0] . '</th>';
                    }
                    echo '<th><input type="checkbox" disabled></th>';
                    echo '</tr>';

                    while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
                        echo '<tr>';
                        echo '<td>' . $row[0] . '</td>';
                        echo '<td>' . $row[1] . '</td>';
                        echo '<td><input type="checkbox" name="cb' . $row[0] . '"></td>';
                        echo '</tr>';
                    }
                    mysqli_free_result($res);
                    ?>
            </table>

            <input type="text" name="country" placeholder="Country" />
            <input type="submit" name="addcountry" value="Add" class="btn btn-sm btn-info" />
            <input type="submit" name="delcountry" value="Delete" class="btn btn-sm btn-warning" />
        </form>
        <?php
        if (isset($_POST['addcountry'])) {
            $country = trim(htmlspecialchars($_POST['country']));
            if ($country == "")
                exit();
            $ins = 'INSERT INTO countries(country) VALUES("' . $country . '")';
            mysqli_query($mysql, $ins);
            echo "<script>";
            echo "window.location=document.URL;";
            echo "</script>";
        }
        if (isset($_POST['delcountry'])) {
            foreach ($_POST as $k => $v) {
                if (substr($k, 0, 2) == "cb") {
                    $idc = substr($k, 2);
                    $del = 'DELETE FROM countries WHERE id=' . $idc;
                    mysqli_query($mysql, $del);
                }
            }
            echo "<script>";
            echo "window.location=document.URL;";
            echo "</script>";
        }
        ?>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-6 right">
        <!-- Cities form -->
        <form action="index.php?page=4" method="post" class="input-group" id="formcity">
            <p>Cities</p>
            <?php
            $sel = 'SELECT ci.id, ci.city, co.country FROM countries co, cities ci WHERE ci.countryid=co.id ORDER BY id';
            $res = mysqli_query($mysql, $sel);
            ?>
            <table class="table table-striped">
                <tr>
                    <th>id</th>
                    <th>city</th>
                    <th>county</th>
                    <th>
                        <input type="checkbox" disabled />
                    </th>
                </tr>

                <?php
                while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
                    echo '<tr>';
                    echo '<td>' . $row[0] . '</td>';
                    echo '<td>' . $row[1] . '</td>';
                    echo '<td>' . $row[2] . '</td>';
                    echo '<td><input type="checkbox" name="ci' . $row[0] . '"></td>';
                    echo '</tr>';
                }
                ?>
            </table>
            <?php
            mysqli_free_result($res);
            $res = mysqli_query($mysql, 'SELECT * FROM countries');
            ?>
            <select name="countryname" class="formcontrol">
                <?php
                while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
                    echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                }
                ?>
            </select>
            <input type="text" name="city" placeholder="City" />
            <input type="submit" name="addcity" value="Add" class="btn btn-sm btn-info" />
            <input type="submit" name="delcity" value="Delete" class="btn btn-sm btn-warning" />
        </form>
        <?php
        if (isset($_POST['addcity'])) {
            $city = trim(htmlspecialchars($_POST['city']));
            if ($city == "")
                exit();
            $countryid = $_POST['countryname'];
            $ins = 'INSERT INTO cities (city,countryid) VALUES ("' . $city . '",' . $countryid . ')';
            mysqli_query($mysql, $ins);
            $err = mysqli_errno($mysql);
            if ($err) {
                echo 'Error code:' . $err . '<br>';
                exit();
            }
            echo "<script>";
            echo "window.location=document.URL;";
            echo "</script>";
        }
        if (isset($_POST['delcity'])) {
            foreach ($_POST as $k => $v) {
                if (substr($k, 0, 2) == "ci") {
                    $idc = substr($k, 2);
                    $del = 'DELETE FROM cities WHERE id=' . $idc;
                    mysqli_query($mysql, $del);
                }
            }
            echo "<script>";
            echo "window.location=document.URL;";
            echo "</script>";
        }
        ?>
    </div>
</div>
<hr />
<div class="row">
    <div class=" col-sm-6 col-md-6 col-lg-6 left ">
        <!-- form Hotels -->

        <form action="index.php?page=4" method="post" class="input-group" id="formhotel">
            <div class="container">
                <p>Hotels</p>
                <?php
                $sel = 'SELECT ci.id, ci.city, ho.id, ho.hotel, ho.cityid, ho.countryid, ho.stars, ho.info, co.id, co.country FROM cities ci, hotels ho, countries co WHERE ho.cityid=ci.id AND ho.countryid=co.id';
                $res = mysqli_query($mysql, $sel);
                $err = mysqli_errno($mysql);
                echo '<table class="table" width="100%">';
                ?>
                <table class="table table-striped">
                    <tr>
                        <th>id</th>
                        <th>city-county</th>
                        <th>hotel</th>
                        <th>star</th>
                        <th>
                            <input type="checkbox" disabled />
                        </th>
                    </tr>
                    <?php
                    while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
                        echo '<tr>';
                        echo '<td>' . $row[2] . '</td>';
                        echo '<td>' . $row[1] . "-" . $row[9] . '</td>';
                        echo '<td>' . $row[3] . '</td>';
                        echo '<td>' . $row[6] . '</td>';
                        echo '<td><input type="checkbox" name="hb' . $row[2] . '"></td>';
                        echo '</tr>';
                    }
                    ?>
                </table>
                <?php
                mysqli_free_result($res);
                $sel = 'SELECT ci.id, ci.city, co.country, co.id FROM countries co, cities ci WHERE ci.countryid=co.id';
                $res = mysqli_query($mysql, $sel);
                $csel = array();
                ?>
                <div class="row g-3 align-items-center">
                    <div class="mb-3">
                        <select name="hcity" class="">
                            <?php
                            while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
                                echo '<option value="' . $row[0] . '">' . $row[1] . " : " . $row[2] . '</option>';
                                $csel[$row[0]] = $row[3];
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row g-3 align-items-center">
                    <div class="mb-3">
                        <input type="text" name="hotel" placeholder="Hotel" />
                        <input type="text" name="cost" placeholder="Cost" />
                    </div>
                </div>
                <div class="row g-3 align-items-center">
                    <div class="mb-3">
                        <lable for="stars">Stars: </lable>
                        <input type="number" name="stars" min="1" max="5" />
                    </div>
                </div>
                <div class="row g-3 align-items-center">
                    <div class="mb-3">
                        <textarea name="info" placeholder="Description"></textarea>
                    </div>
                </div>
                <div class="row g-3 align-items-center">
                    <div class="mb-3">
                        <input type="submit" name="addhotel" value="Add Hotel" class="btn btn-sm btn-info" />
                        <input type="submit" name="delhotel" value="Delete Hotel" class="btn btn-sm btn-warning" />
                    </div>
                </div>
            </div>

        </form>
        <?php
        mysqli_free_result($res);
        if (isset($_POST['addhotel'])) {
            $hotel = trim(htmlspecialchars($_POST['hotel']));
            $cost = intval(trim(htmlspecialchars($_POST['cost'])));
            $stars = intval($_POST['stars']);
            $info = trim(htmlspecialchars($_POST['info']));
            if ($hotel == "" || $cost == "" || $stars == "")
                exit();
            $cityid = $_POST['hcity'];
            $countryid = $csel[$cityid];
            $ins = 'INSERT INTO hotels (hotel,cityid,countryid,stars,cost,info) VALUES ("' . $hotel . '",' . $cityid;
            $ins .= "," . $countryid . ',' . $stars . ',' . $cost . ',"' . $info;
            $ins .= '")';
            mysqli_query($mysql, $ins);
            echo "<script>";
            echo "window.location=document.URL;";
            echo "</script>";
        }
        if (isset($_POST['delhotel'])) {
            foreach ($_POST as $k => $v) {
                if (substr($k, 0, 2) == "hb") {
                    $idc = substr($k, 2);
                    $del = 'DELETE FROM hotels WHERE id=' . $idc;
                    mysqli_query($mysql, $del);
                    if ($err) {
                        echo 'Error code:' . $err . '<br />';
                        exit();
                    }
                }
            }
            echo "<script>";
            echo "window.location=document.URL;";
            echo "</script>";
        }
        ?>
    </div>
    <div class=" col-sm-6 col-md-6 col-lg-6 right ">
        <!-- Images form -->

        <form action="index.php?page=4" method="post" enctype="multipart/form-data" class="input-group">
            <div class="container">
                <div class="row g-3 align-items-center">
                    <div class="col mb-3">
                        Photo
                    </div>
                </div>

                <div class="row g-3 align-items-center">
                    <div class="col mb-3">
                        <select name="hotelid">
                            <?php
                            $sel = 'SELECT ho.id, co.country,ci.city,ho.hotel FROM countries co,cities ci, hotels ho WHERE co.id=ho.countryid AND ci.id=ho.cityid ORDER BY co.country';
                            $res = mysqli_query($mysql, $sel);
                            while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
                                echo '<option value="' . $row[0] . '">';
                                echo $row[1] . '&nbsp;&nbsp;' . $row[2] . '&nbsp;&nbsp;' . $row[3] . '</option>';
                            }
                            mysqli_free_result($res);
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row g-3 align-items-center">
                    <div class="mb-3">
                        <!--<input type="file" name="file[]" multiple accept="image/*" oninput="pic.src=window.URL.createObjectURL(this.files[])" />-->
                        <input type="file" id="image" name="image[]" multiple accept="image/*" />

                        <input type="submit" name="addimage" value="Add image" class="btn btn-sm btn-info" />
                    </div>

                    <div class="mb-3">
                        <div id="pic" style="display: grid; grid-template-columns: 1fr 1fr">
                            <script type="text/javascript">
                                $(document).ready(function () {
                                    $('#image').change(function () {
                                        $("#pic").html('');
                                        //php??? נאחלונ פאיכא???
                                        for (var i = 0; i < $(this)[0].files.length; i++) {
                                            $('#pic').append('<div id="img' + i + '" >');
                                            $(('#img' + i)).append('<div style="position:absolute; z-index:1; zoom: 2"><input type="checkbox" name="check[' + i + ']" id="pb' + i + '" class="form-check-label " /></div>');
                                            $('#pic').append('</div>');
                                            $(('#img' + i)).append('<div style="position:relative; display:block"><img src="' + window.URL.createObjectURL(this.files[i]) + '" class="img-fluid img-thumbnail w-100"/></div>');

                                        };

                                    });
                                });
                            </script>

                        </div>

                    </div>

                </div>


            </div>

        </form>




        <?php
        if (isset($_REQUEST['addimage'], $_REQUEST["check"], $_FILES['image'])) {
            $hid = $_REQUEST['hotelid'];
            $uploadFolder = $_SERVER['DOCUMENT_ROOT'] . '\\images\\' . $hid . '\\';
            if (!is_dir($uploadFolder . $hid)) {
                mkdir($uploadFolder);
            }

            foreach ($_REQUEST["check"] as $c => $on) {
                $v = $_FILES["image"]["name"][$c];

                //echo $c;
                //foreach ($_FILES['image']['name'] as $k => $v) {
                //    if ($k == $c) {
                if ($_FILES['image']['error'][$c] != 0) {
                    //echo '<script>alert("Upload file error:' . $v . '")</script>';
                    echo '<script>alert("Upload file error:' . $v . '")</script>';
                    continue;
                }


                if (
                    move_uploaded_file($_FILES['image']['tmp_name'][$c], $uploadFolder . $v)
                ) {
                    $ins = 'INSERT INTO images(hotelid,imagepath) VALUES(' . $hid . ',"images/' . $hid . '/' . $v . '")';
                    mysqli_query($mysql, $ins);
                    echo 'Image ' . $v . ' uploaded <br/>';
                }
                //}
                //}
            }


            //echo "<script>";
            //echo "window.location=document.URL;";
            //echo "</script>";
        }
        ?>

    </div>
</div>




