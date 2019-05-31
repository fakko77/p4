<?php
class Article{
    private $_titre;
    private $_contenu;
    private $_date;

    function __construct($titre, $contenu ,$date)
    {
        $this->_titre = $titre;
        $this->_contenu = $contenu;
        $this->_date = $date;
    }

    public function titre(){

       return $this->_titre;
    
    }
    public function contenu(){
        
        return $this->_contenu;
    }
    public function date(){

        return $this->_date;
    }
    public function miseEnForme(){

    echo"<h1> $this->_titre</h1>";
    echo"<br>";
    echo"<p>$this->_contenu</p>";
    echo"<br>";

    echo "<blockquote class='blockquote'>Derniere modification le  $this->_date </blockquote>";
    }


}


function getDataBaseConnexion(){

    try  
    {  $host = "localhost";  
        $username = "root";  
        $password = "";  
        $database = "p4";  
        $message = "";  
         $pdo = new PDO("mysql:host=$host; dbname=$database", $username, $password);  
         $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
         return $pdo;
} catch (PDOException $e) {
  echo 'Connexion échouée : ' . $e->getMessage();
  die();
}

}
function readArticlePage($id){
    $con = getDataBaseConnexion();
    $req = "SELECT * from articles where id = '$id'"; 
    $stmt = $con->query($req);

    while($donnees = $stmt->fetch()){
     $titre = "$donnees[titre]";
     $contenu = "$donnees[contenu]";
     $date = "$donnees[date]";
     $article = new Article($titre,$contenu,$date);
     return $article;
    }
}

function getAllArticles(){
$con = getDataBaseConnexion();
$req = 'SELECT * from articles'; 
$rows = $con->query($req);
return $rows;

}
function afficherCom($id){
    $con = getDataBaseConnexion();
    $req = "SELECT * from com where articleId = '$id'"; 
    $stmt = $con->query($req);

    while($donnees = $stmt->fetch()){
      echo"<i class='fas fa-id-card'></i> : $donnees[nom]";
      echo"<br>";
      echo"<i class='far fa-comments'></i> : $donnees[com]";
      echo"<br>";
      echo"<a href='signaler.php?idcom=$donnees[id]&id=$id' title='Signaler le commentaire'><i class='fas fa-exclamation-triangle'></i></a>";
      echo"<br>";
      echo"<br>";

     
     
    }

}
function comS(){
    $con = getDataBaseConnexion();
    $req = "SELECT * from com where signaler = '1'"; 
    $stmt = $con->query($req);

    while($donnees = $stmt->fetch()){
   
        echo"<i class='fas fa-id-card'></i> : $donnees[nom]";
        echo"<br>";
        echo"<i class='far fa-comments'></i> : $donnees[com]";
        echo"<br>";
        echo"<a href='admin-com.php?id=$donnees[articleId]' title='gerer'><i class='fas fa-cog'></i></a>";
    
        echo"<br>";
        echo"<br>";
    }


}
function afficherComAdmin($id){
    $con = getDataBaseConnexion();
    $req = "SELECT * from com where articleId = '$id'"; 
    $stmt = $con->query($req);

    while($donnees = $stmt->fetch()){

        $a = "$donnees[signaler]";
       
            
            if($a == 1){
                echo "<span style ='background:rgba(193,66,66,0.5);'>";
            echo"<i class='fas fa-id-card'></i> : $donnees[nom]";
            echo"<br>";
            echo"<i class='far fa-comments'></i> : $donnees[com]";
            echo"<br>";
            echo"<a href='deleteCom.php?idcom=$donnees[id]&id=$id' title='Supprimer commentaire'><i class='fas fa-trash-alt'></i></a>";
            echo"</span>";
            }else {

                echo "<span style =''>";
                echo"<i class='fas fa-id-card'></i> : $donnees[nom]";
                echo"<br>";
                echo"<i class='far fa-comments'></i> : $donnees[com]";
                echo"<br>";
                echo"<a href='deleteCom.php?idcom=$donnees[id]&id=$id' title='Supprimer commentaire'><i class='fas fa-trash-alt'></i></a>";
                echo"</span>";
            }
            echo"<br>";
            echo"<br>";

     
     

     
     
    }

}


function signaler($idcom){
    $con = getDataBaseConnexion();
    $req = "UPDATE com set signaler = '1' where id = '$idcom'"; 
    $stmt = $con->query($req);


}

function readArticle($id){
    $con = getDataBaseConnexion();
    $req = "SELECT * from articles where id = '$id'"; 
    $stmt = $con->query($req);

    while($donnees = $stmt->fetch()){
      echo  "<form method='post'>  
      <input style='display:none;' name='id' type='text' value='$donnees[id]' disabled />
                     <label>Titre</label>  
                     <input type='text' name='titre' class='form-control' value='$donnees[titre]' />  
                     <br />  
                     <label>Text</label>  

                      <textarea name='area1'   style='width: 100%;'>$donnees[contenu]</textarea>
<br />

                     <br />  
                     <input type='submit' name='update' class='btn btn-info' value='send' />  
                </form>  ";
      

     
     
    }
    
   
}

function creatArticle($titre , $contenu){
try {
    $con = getDataBaseConnexion();
    $req = "INSERT INTO articles (titre,contenu) values ('$titre','$contenu')"; 
    $stmt = $con->query($req);
    header("location:admin-panel.php"); 
} catch(PDOException $e){

}
    
}
function creatCom($nom , $com , $id ){
    try {
        $con = getDataBaseConnexion();
        $req = "INSERT INTO com (nom,com, articleId) values ('$nom','$com','$id')"; 
        $stmt = $con->query($req);
        header("location:post?id=$id"); 
    } catch(PDOException $e){
        echo $e;
    }
}
        

function updateArticle($titre , $contenu,$id){
    try {
        $con = getDataBaseConnexion();
        $req = "UPDATE articles set titre = '$titre' , contenu = '$contenu' where id = '$id'"; 
        $stmt = $con->query($req);
        header("location:admin-edit.php");  
      
    } catch(PDOException $e){
    
    }
        
    }

function afficherTitre($id){
    try {
        $con = getDataBaseConnexion();
        $req = "SELECT titre from articles where id = '$id'"; 
        $stmt = $con->query($req);
        while($donnees = $stmt->fetch()){
            echo "<h2>$donnees[titre]</h2>";
        }
      
    } catch(PDOException $e){
    
    }


}
function deleteArticle($id){

    try {
        $con = getDataBaseConnexion();
        $req = "DELETE FROM articles where id = '$id'"; 
        $stmt = $con->query($req);
      
    } catch(PDOException $e){
    
    }
        
    }

function deleteCom($idcom){


    try {
        $con = getDataBaseConnexion();
        $req = "DELETE FROM com where id = '$idcom'"; 
        $stmt = $con->query($req);
      
    } catch(PDOException $e){
    
    }
        
    }



function tableau(){
    try {
        $con = getDataBaseConnexion();
        $req = "SELECT * FROM articles ORDER BY date desc"; 
        $stmt = $con->query($req);

        while($donnees = $stmt->fetch()){
            echo "</tr>";
           
            // echo "<td> $donnees[RA] </td>";
             echo "<td> $donnees[titre] </td>";
             echo "<td> $donnees[contenu] </td>";
             echo "<td> $donnees[date] </td>";
             
             $a = "$donnees[id]";
             echo "<td><a href='delete.php?id=$a'><button
             type='button'>
         supprimer
     </button></a></td>";
     echo "<td><a href='update.php?id=$a'><button
     type='button'>
 update
</button></a></td>";
echo"<td><a href='admin-com.php?id=$a'><i class='far fa-comments'></i></a></td>";
    
         
         
        }
      
    } catch(PDOException $e){
    
    }

}

function articleView(){


    try {
        $con = getDataBaseConnexion();
        $req = "SELECT * FROM articles ORDER BY date desc"; 
        $stmt = $con->query($req);

        while($donnees = $stmt->fetch()){
            $a = "$donnees[id]";
            echo"<div class='post-preview'>
            <a href='post.php?id=$a'>
              <h2 class='post-title'>
              $donnees[titre]
              </h2>
              <h3 class='post-subtitle'>
              $donnees[contenu]...
              </h3>
            </a>

            <p class='post-meta'>Publier le $donnees[date]</p>
          </div>
          <hr>";
         
        }
      
    } catch(PDOException $e){
    
    }

}


?>