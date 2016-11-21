<?php
/**
 * Copyright 2016 TODO
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @file course_delete.php
 * Webpage for deleting a single course
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User Permissions</title>

    <link rel="stylesheet" href="../external/jasny-bootstrap/dist/css/jasny-bootstrap.min.css"/>
</head>

<body>
<?php include("menu.php"); ?>

<?php
// Get all course data and name + email of their creators from our database based
// on the subject id given in the website URL
include '../php/db_connect.php';
include '../php/tools.php';
include '../php/user_management.php';


if ($_POST != null) {
    if ($_POST['confirmed'] == 'on') {
        $confirmed = 1;
    } else {
        $confirmed = 0;
    }
    $sqlUpdate = 'UPDATE users SET confirmed = ' . $confirmed . ', role = ' . $_POST['role'] . ' WHERE id = ' . $_POST['id'];
    $sth = $db->prepare($sqlUpdate);
    $ret = $sth->execute();
    if ($ret === false) {
        error_log('Error: user update in database failed!');
        die('Could not update user.');
    }
}

$users = $db->query("SELECT * FROM users");


?>
<header id='head' class='secondary'>
    <div class='container'>
        <div class='row'>
            <h1><?php echo 'User Management' ?></h1>
        </div>
    </div>
</header>

<div id='courses'>
    <section class='container'>
        <div class='container'>
            <div class='row'>
                <!-- List of all users -->
                <div class='col-sm-8'>
                    <h3>User List</h3>

                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Confirmed</th>
                            <th>Role</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($users)) {
                            while ($user = $users->fetch()) { ?>
                                <tr>
                                    <form method="POST" id=<?php $user['id'] ?>>
                                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                        <td><?= $user['family_name'] ?>, <?= $user['given_name'] ?></td>
                                        <td><input type="checkbox"
                                                   name="confirmed" <?php if ($user['confirmed'] == 1) echo 'checked' ?> >
                                        </td>
                                        <td>
                                            <select name='role'>
                                                <option value="1" <?php if ($user['role'] == 1) echo 'selected' ?> >
                                                    Creator
                                                </option>
                                                <option value="2" <?php if ($user['role'] == 2) echo 'selected' ?> >
                                                    Trainer
                                                </option>
                                                <option value="3" <?php if ($user['role'] == 3) echo 'selected' ?> >
                                                    Developer
                                                </option>
                                                <option value="4" <?php if ($user['role'] == 4) echo 'selected' ?> >
                                                    Learner
                                                </option>
                                            </select>
                                        </td>
                                        <td><input type="submit" value="Submit">

                                    </form>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </section>
</div>
<!-- container -->

<?php include("footer.php"); ?>

<script type="text/javascript" src="../js/tools.js"></script>
<?php
//Decide if this site is inside a separate widget
if (filter_input(INPUT_GET, "widget") == "true") {
    print("<script src='../js/overview-widget.js'> </script>");
}
?>
<!-- Library which defines behavior of the <table class="table table-striped table-bordered table-hover"> -->
<script src="../external/jasny-bootstrap/dist/js/jasny-bootstrap.min.js"></script>
<script src="../js/course-list.js"></script>
</body>
</html>
