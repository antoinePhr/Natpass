<?php

use Antoine\Database;
use Symfony\Component\VarDumper\Cloner\Data;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class ImportVideo{

    private $name; // nom de la vidéo
    private $description; 
    private $analyse; // 
    private $pathAU; // after upload
    private $pathBU; // before upload
    private $thumbnail; // miniature
    private $tempName; // nom temporaire donnée par $_FILES
    private $category; // catégorie choisie
    private $nageur;
    private $config;

    
    public function __construct(){
        $this->name = htmlspecialchars($_POST['videoName']);
        $this->category = htmlspecialchars($_POST['category']);
        $this->description = htmlspecialchars($_POST['videoDescription']);
        $this->analyse = htmlspecialchars($_POST['videoAnalyse']) ?? null;
        $this->pathBU = htmlspecialchars($_FILES['file']['tmp_name']);
        $this->pathAU = "videos/".$this->category."/".$this->name. ".mp4";
        $this->nageur = htmlspecialchars($_POST['nageur']);
       
        $this->tempName = $_FILES['file']['tmp_name'];
        $this->config =  
        [
            'ffmpeg.binaries' => '/usr/bin/ffmpeg',
            'ffprobe.binaries' => '/usr/bin/ffprobe',
            'timeout' => 3600, // The timeout for the underlying process
            'ffmpeg.threads' => 12, // The number of threads that FFMpeg should use
        ];
    }
    public function moveVideo(){
        if(file_exists("videos/".$this->category)){
            if(!file_exists($this->pathAU)){
                $uploaded =  move_uploaded_file($this->tempName, $this->pathAU);
                if($uploaded){
                  $succ = "Importation réussie";
                  return $succ;
                }
                else{  
                    $err =  "une erreur survenue lors de l'importation";
                    return $err;
                }
            }
            else{
                echo "<p class='importError'> La vidéo existe déjà </p>";
            }
        }
        else{
            mkdir("videos/".$this->category);
            $this->moveVideo();
        }
        
    }
    public function generateThumbnail(){
        if(file_exists("videos/thumbnails/".$this->category)){
            $ffmpeg = FFMpeg\FFMpeg::create($this->config);
            $video = $ffmpeg->open($this->pathAU);
            $video
                ->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(random_int(0, $this->videoDuration())))
                ->save("videos/thumbnails/".$this->category.'/'.$this->name.".jpg");
            
            $this->thumbnail = $this->category. "/".$this->name.".jpg";
        }
        else{
            mkdir("videos/thumbnails/".$this->category);
            $this->generateThumbnail();
        }
    }
    public function videoDuration(){    
        $ffProb = FFMpeg\FFProbe::create($this->config);
        $duration = $ffProb
           ->streams($this->pathAU)
           ->videos()                   
           ->first()                  
           ->get('duration');

        return floor($duration);
    }

    public function addVideoInfoDB(){
            $conn = new Database("natpass");
            $query = "INSERT INTO video(
                video.vd_titre, video.vd_chemin, video.vd_description, video.vd_analyse, video.vd_duree, video.vd_thumbnail, video.vd_fk_ngr_id)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
            $params = [];
            array_push($params, $this->name, $this->pathAU, $this->description, $this->analyse, $this->videoDuration(), $this->thumbnail, $this->nageur);
            $conn->insertQuery($query, $params);
    }
    
}

?>