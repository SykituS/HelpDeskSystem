<?php

require 'conn.php';

$query = 'SELECT * FROM blog';

$result = $context->query($query);

echo '<h1>MySql Content:</h1>';

while($record = mysqli_fetch_assoc($result))
{
    echo '<h2>'.$record['title'].'</h2>';
    echo '<p>'.$record['content'].'</p>';
    echo 'Posted: '.$record['date'];
    echo '<hr>';
}