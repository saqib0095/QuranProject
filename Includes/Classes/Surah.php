<?php

class Surah{
  private $con;
  private $id;
  private $mysqliData;
  private $title;
  private $artistId;
  private $albumid;
  private $genre;
  private $duration;
  private $path;

  public function  __construct($con, $id) {
    $this->con = $con;
    $this->id = $id;

    $Query = mysqli_query($this->con, "SELECT * FROM surah WHERE id='$this->id'");
    $this->mysqliData = mysqli_fetch_array($Query);

    $this->title = $this->mysqliData['title'];
    $this->artistId = $this->mysqliData['artist'];
    $this->albumid = $this->mysqliData['album'];
    $this->genre = $this->mysqliData['genre'];
    $this->duration = $this->mysqliData['duration'];
    $this->path = $this->mysqliData['path'];

  }
  public function getTitle(){
    return $this->title;
  }
   public function getId(){
    return $this->id;
  }
  public function getArtist(){
    return new Artist($this->con, $this->artistId);
  }
  public function getAlbum(){
    return new Album($this->con, $this->albumid);
  }
  public function getGenre(){
    return $this->genre;
  }
  public function getDuration(){
    return $this->duration;
  }
  public function getPath(){
    return $this->path;
  }
  public function getMysqliData(){
    return $this->mysqliData;
  }
}


  ?>
