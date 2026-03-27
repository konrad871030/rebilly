<?php
// getting the total number of rows in the table
$count = $pdo->query('SELECT COUNT(*) FROM largeTable')->fetchColumn();
// setting the number of rows per page
$perPage = 100;
// calculating the number of pages
$pages = ceil($count / $perPage);
// looping through the pages
for ($i = 0; $i < $pages; $i++) {
  // preparing the statement to get the rows for the current page
  $stmt = $pdo->prepare('SELECT * FROM largeTable LIMIT :offset, :perPage');
  $stmt->bindValue(':offset', $i * $perPage, PDO::PARAM_INT);
  $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
  $stmt->execute();
  // getting the rows for the current page
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  // looping through the rows
  foreach ($results as $result) {
    // manipulate the data here
  }
}