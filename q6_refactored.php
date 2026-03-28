<?php

class Document {

  public $user;

  public $name;

  public function __construct($name, User $user) {
    assert(strlen($name) > 5);
    $this->user = $user;
    $this->name = $name;
  }

  public function getTitle() {
    $db = Database::getInstance();
    $row = $db->query('SELECT * FROM document WHERE name = "' . $this->name . '" LIMIT 1')->fetch_assoc();
    return $row['title'];
  }

  public static function getAllDocuments() {
    // to be implemented later
  }
}

class User {

  public function makeNewDocument($name) {
    if (strpos(strtolower($name), 'senior') === false) {
      throw new Exception('The name should contain "senior"');
    }

    return new Document($name, $this);
  }

  public function getMyDocuments() {
    $list = [];
    foreach (Document::getAllDocuments() as $doc) {
      if ($doc->user === $this) {
        $list[] = $doc;
      }
    }
    return $list;
  }
}
