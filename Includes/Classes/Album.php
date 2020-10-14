<?php

class Album{
  private $con;
  private $id;
  private $artistId;
  private $title;
  private $genre;
  private $artworkpath;


  public function  __construct($con, $id) {
    $this->con = $con;
    $this->id = $id;

    $Query = mysqli_query($this->con, "SELECT * FROM albums WHERE id='$this->id'");
    $album = mysqli_fetch_array($Query);

    $this->title = $album['title'];
    $this->artistId = $album['artist'];
    $this->genre = $album['genre'];
    $this->artworkpath = $album['artworkpath'];

  }
  public function getTitle(){
    return $this->title;

  }
  public function getArtist(){
  return new Artist($this->con,$this->artistId);
  }
  public function getGenre(){
    return $this->genre;
  }
  public function getArtwork(){
    return $this->artworkpath;
  }
  public function getNumberOfSongs(){
    $Query = mysqli_query($this->con, "SELECT id FROM surah WHERE album='$this->id'");
    return mysqli_num_rows($Query);
  }
  public function getSurahIds(){
    $Query = mysqli_query($this->con, "SELECT id FROM surah WHERE album ='$this->id' ORDER BY albumorder ASC");
    $array = array();
    while ($row = mysqli_fetch_array($Query)) {
      array_push($array, $row['id']);

    }
      return $array;
  }
}


  ?>
