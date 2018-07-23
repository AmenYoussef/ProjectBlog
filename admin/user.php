<?php

ob_start(); // Output Buffering Start

session_start();

include 'system/ini.php';

LoginOrNo(); // I'm login Or no


$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';


if ($do == 'Manage') {

    $stmt = $con->prepare('SELECT * FROM user');

    $stmt->execute();

    $row = $stmt->fetchALL();

    ?>

    <h1 class="text-center">Welcom To Manage User</h1>

    <div class="container">
        <table class="main-table table-bordered table tableShowUser">

            <tr class='text-center'>
                <td>UserID</td>
                <td>Username</td>
                <td>FullName</td>
                <td>Email</td>
                <td>Rank</td>
                <td>Data</td>
                <td>Opthon</td>
            </tr>


        <?php

            foreach ($row as $rows) {

                echo '<tr>';

                echo '<td>' . $rows['UserID'] . '</td>';
                echo '<td>' . $rows['Username'] . '</td>';
                echo '<td>' . $rows['Fullname'] . '</td>';
                echo '<td>' . $rows['Email'] . '</td>';

                if ($rows['GroupID'] == 1) {

                    echo '<td>Adminstrator</td>';

                } elseif ($rows['Rank'] == 0) {

                    echo '<td>User</td>';

                } else {

                    echo '<td>None<td>';

                }

                echo '<td>' . $rows['Time'] . '</td>';

                echo '<td> <a href="user.php?do=Edit&UserID='. $rows['UserID'] .'" class="btn btn-xs btn-success">Edait</a>';

                echo '<a href="user.php?do=Delete&UserID='. $rows['UserID'] .'" class="btn btn-xs btn-danger">Dealit</a>';

                if ($rows['Rank'] == 0) {

                    echo '<a href="#" class="btn btn-xs btn-info">Active</a>';

                }

                echo '</td>';
                echo '</tr>';



            }

        ?>

        </table>
    </div>

    <?php

} elseif ($do == 'Delete') {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        echo "<h1 class='text-center'>Delete Member</h1>";
                echo "<div class='container'>";
                    // Check If Get Request userid Is Numeric & Get The Integer Value Of It
                    $userid = isset($_GET['UserID']) && is_numeric($_GET['UserID']) ? intval($_GET['UserID']) : 0;
                    // Select All Data Depend On This ID
                    $check = checkItem('UserID', 'user', $userid);
                    // If There's Such ID Show The Form
                    if ($check > 0) {
                        $stmt = $con->prepare("DELETE FROM user WHERE UserID = ?");
                        $stmt->execute(array($userid));

                        echo '<h1 class="text-center">This User Deleted Now</h1>';
                    } else {

                        include $foldertemp . '404.php';

                    }
                echo '</div>';


     } else {

        include $foldertemp . '404.php';

     }
} elseif ($do == 'Edit') {

    // Check If Get Request userid Is Numeric & Get The Integer Value Of It
    $userid = isset($_GET['UserID']) && is_numeric($_GET['UserID']) ? intval($_GET['UserID']) : 0;
    // Select All Data Depend On This ID
    $check = checkItem('UserID', 'user', $userid);

    $stmt = $con->prepare('SELECT * FROM user WHERE UserID = ?');

    $stmt->execute(array($userid));

    $row = $stmt->fetch();

    if($check > 0) {

        ?>

            <h1 class="text-center">Edit User <?php echo $row['Username']; ?></h1>

            <div class="container">

            <Form action="?do=Update" method="POST">

                <div class="row">

                    <div class="col-md-6">

                        <div class="form-group">

                          <input type="hidden" name="ID" value="<?PHP echo $row['UserID']; ?>">

                            <input type="text" class="form-control" Value = '<?PHP echo $row['Username']; ?>' name="Username" placeholder="Username">

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="form-group">

                            <input type="text" class="form-control" Value = '<?PHP echo $row['Fullname']; ?>' name="Fullname" placeholder="FullName">

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="form-group">

                            <input type="text" class="form-control" Value = '<?PHP echo $row['Email']; ?>' name="Email" placeholder="Email">

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="form-group">

                            <input type="number" class="form-control" Value = '<?PHP echo $row['Phone']; ?>' name="Phone" placeholder="Phone">

                        </div>

                    </div>

                    <div class="col-md-12">

                        <div class="form-group text-center">

                            <input type='checkbox' id='blockUser' <?php if($row['Rank'] == 0) { echo 'Checked';} ?>> <label for="blockUser"> Ban User</label>
                            <input type='checkbox' id='TakeAdminstrator' <?php if ($row['GroupID'] == 1) { echo 'Checked';} ?> > <label for="TakeAdminstrator"> Adminstrator</label>

                        </div>

                    </div>


                    <div class="col-md-12">

                        <div class="form-group text-center">

                            <input class='btn btn-sm btn-success' type='submit' value='Send'>

                        </div>

                    </div>

                </div>




            </form>




            </div>




        <?php


        }



    } elseif ($do == 'Update') {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $UserID   = $_POST['ID'];
            $Username = $_POST['Username'];
            $Fullname = $_POST['Fullname'];
            $email    = $_POST['Email'];
            $Phone    = $_POST['Phone'];



            $ErrorForm = array();


            if (empty($Username)) {

                $ErrorForm[] = 'Sorry, Please Input Username';

            } elseif (strlen($Username) < 5) {

                $ErrorForm[] = 'Sorry, Please Input Username > 4';

            }


            if (empty($Fullname)) {

                $ErrorForm[] = 'Sorry, Please Input Full Name';

            } elseif (strlen($Fullname) < 5) {

                $ErrorForm[] = 'Sorry, Please Input Full Name > 4';

            }


            if (empty($Phone)) {

                $ErrorForm[] = 'Sorry, Please Input Phone';

            } elseif (strlen($Phone) < 10) {

                $ErrorForm[] = 'Sorry, Please Input Phone > 10';

            }

            if (empty($email)) {

                $ErrorForm[] = 'Sorry, Please Input Email';

            } elseif (strlen($email) < 8) {

                $ErrorForm[] = 'Sorry, Please Input Email';

            }


            if (empty($ErrorForm)) {

                $checkUser = checkItem('UserID', 'user', $UserID);

                if ($checkUser > 0) {

                        // Update The Database With This Info
						            $stmt = $con->prepare("UPDATE user SET Username = ?, Email = ?, FullName = ?, Phone = ? WHERE UserID = ?");
                        $stmt->execute(array($Username, $email, $Fullname, $Phone, $UserID));

                        ?>

                        <div class="container text-center">

                            <p class="alert alert-success">This Edit Is Agre</P>

                        </div>

                        <?php


                } else {

                  ?>

                  <div class="container">

                    <div class="text-center marrgin">

                        <p class="alert alert-danger">Sorry Thsi Username Is Not Found</P>

                    </div>

                  </div>


                <?php }

            } else { ?>

                <div class="container">

                  <div class="text-center marrgin">

                      <?php
                      foreach ($ErrorForm as $Error) {
                          echo '<p class="alert alert-danger">' . $Error .'</P>';
                      }

                      ?>

                  </div>

                </div>

          <?php }

        } else {

            include $foldertemp . '404.php';

        }

    } else {

        include $foldertemp . '404.php';

    }

    ob_end_flush(); // Release The Output
