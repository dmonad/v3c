<?php
/**
 * Copyright 2015 Adam Brunnmeier, Dominik Studer, Alexandra Wörner, Frederik Zwilling, Ali Demiralp, Dev Sharma, Luca Liehner, Marco Dung, Georgios Toubekis
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
 * @file upload_script_course.php
 *
 * Adds new course to the course database on the server
 * adds metadata about it database.
 */

//create database connection (needs to be done before mysql_real_escape_string)
$conn = require '../php/db_connect.php';

//Get input data from form
$id = filter_input(INPUT_POST, 'targetId');
$lang = filter_input(INPUT_POST, 'targetLang');
$name = filter_input(INPUT_POST, 'name');
$text = filter_input(INPUT_POST, 'text');
$domain = filter_input(INPUT_POST, 'domain');
$profession = filter_input(INPUT_POST, 'profession');


//Creator stays the same

// modify database-entry
$sql = "UPDATE courses SET name='$name', domain='$domain', profession='$profession', description='$text', WHERE id='$id' AND lang='$lang'";

//echo "sqlquery: $sql";

$conn->query($sql);

$html = "";
if (isset($_GET['widget']) && $_GET['widget'] == 'true') {
    $html = "&widget=true";
}

header("Location:../views/course.php?id=$id&lang=$lang&$name&$text&$domain&$profession$html");

?>