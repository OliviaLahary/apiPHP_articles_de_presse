<?php
//type mime: je sais pas a voir 
header("Content-Type:application/json"); //
//recuperation de methode 
$method = $_SERVER['REQUEST_METHOD'];

switch ($method){ //utilisation de switch/case pour faire les series d'instructions mais on aurait pu utiliser if 
    case "GET": //parametres Pour le cas ou la methode est GET recupération des données demandées.
        // si article est présent et == null
        // alors on recupere tous les articles
            // sinon si articles est > 0
            // alors on affiche l'article avec l'id =article
        // sinon erreur
        if (isset($_GET['article'])){ //(l'url: http://localhost/appli/api.php?article ) isset verifie si la variable est definie (et nulle) RECUPERATION DE TOUS LES ARTICLES

            if ($_GET['article']==""){ //si article est présent dans l'url et = nul, on recupère tous les articles 

                include('connexion.php'); //conn bdd

                $data = $conn->query("SELECT * FROM article")->fetchAll(PDO::FETCH_ASSOC);//ariable $data= $conn(variables de connection à la table de la database info (voir connection.php)) ->query("requète sql")(select tous les articles dans le tableau "article" de la base de donnée info) , fetchAll: execution de la requete qui retourne les données(pdo fetch_accoc:  Retourne la ligne suivante en tant qu'un tableau indexé par le nom des colonnes )

                echo json_encode($data); //Retourne la représentation JSON d'une valeur

                $conn = null; //fermeture de la connection a faire à chaque boucle
                
            }elseif ($_GET["article"]>0){ //afficher un article grace à son id -> $GET['article']= Dans l'url; http://loclahost/appli/api.php?(resultat$_GET)article={id}
                 
                include('connexion.php'); //conn bdd
                
                $data = $conn->query("SELECT * FROM article WHERE id=".$_GET['article'])->fetchAll(PDO::FETCH_ASSOC); // variable $data= $conn(variables de connection à la table de la database info (voir connection.php)) ->query("requète sql")(select tous les articles dans le tableau "article" de la base de donnée info ayant un id correspondant à l'id demandé dans le formulaire) , fetchAll: execution de la requete qui retourne les données(pdo fetch_accoc:  Retourne la ligne suivante en tant qu'un tableau indexé par le nom des colonnes )


                echo json_encode($data); //Retourne la représentation JSON d'une valeur

                $conn = null; //fermeture conn bdd
            }else{
                echo"erreur";//a voir si ca marche sinon changer.
            };


        }elseif (isset($_GET['category'])){  ////(l'url: http://localhost/appli/api.php?(resultat$_GET['category'])category ) isset verifie si la variable est definie (et nulle) RECUPERATION DE TOUTES LES CATEGORIES
        
            // si category est présent et == null
            // alors on recupere tous les categories
            // sinon erreur

            if($_GET['category']==""){ // si category est présent dans l'url et = nul, on recupère tous les categories 

                include('connexion.php');//conn bdd
                
                $data = $conn->query("SELECT DISTINCT Category FROM article ")->fetchAll(PDO::FETCH_ASSOC); // variable $data= $conn(variables de connection à la table de la database info (voir connection.php))->query("requète sql")(selectionne toutes les categories de maniére unique (le DISTINCT sert à ça) dans le tableau article de la base de données info), fetchAll: execution de la requete qui retourne les données(pdo fetch_accoc:  Retourne la ligne suivante en tant qu'un tableau indexé par le nom des colonnes )

                echo json_encode($data);//Retourne la représentation JSON d'une valeur

                $conn = null;//fermeture conn bdd
                
            }else{
                echo "erreur ";//voir quel type d'erreur a mettre
            };
        }elseif(isset($_GET['artParCat'])){ ////recupération des articles par categories (l'url: http://localhost/appli/api.php? (resultat $_GET['artParCat'])artParCat=category ) isset verifie si la variable est definie et nulle

            //si artParCat est présent
            //si artParCat est différent de null
            //alors recuperation des articles avec la category artParCat
            // sinon erreur

            if($_GET['artParCat']!=""){  //si artParCat est présent dans l'url et différent de nul, on recupère tous les articles d'une categorie donnée

                include('connexion.php'); //conn bdd
            
                $data = $conn->query("SELECT * FROM article WHERE Category LIKE '".$_GET['artParCat']."'")->fetchAll(PDO::FETCH_ASSOC);  // variable $data= $conn(variables de connection à la table de la database info (voir connection.php))->query("requète sql")(selectionne tous les articles qui ont une categorie donnée  dans le tableau article de la base de données info), fetchAll: execution de la requete qui retourne les données(pdo fetch_accoc:  Retourne la ligne suivante en tant qu'un tableau indexé par le nom des colonnes )

                echo json_encode($data);

                $conn = null;//fermeture conn bdd
            }else{
                echo"erreur artParCat";
            };
        }else{
            echo "erreur";
        };
        break;
    case "PUT":   //parametres:  Pour le cas ou la methode est PUT envoi dans la base de donnée ....  methode non supportée par les formulaires html , mise en  evidence dans postman pour l'instant .
        if(isset($_REQUEST['UpVote'])){ //si upvote est present dans l'url (http://localhost/appli/api.php?upvote/{id})
            if($_REQUEST['UpVote']>0){ //

                include('connexion.php'); //conn bdd

                
                $data = $conn->query("UPDATE article SET UpVote = UpVote + 1 WHERE id=".$_REQUEST['UpVote']); //mise a jour d'une ligne de la table article dans la colonne upVote, ajout de 1 dans la ligne qui a l'id correspondant à l'article correspondant

            
                echo"Ajouter +1 à l'article avec l'id " .$_REQUEST['UpVote'];
                $conn = null; //fermeture conn bdd


               
            }else{
                echo"erreur2";
            };
        } elseif(isset($_REQUEST['DownVote'])){ //si downvote est present dans l'url (http://localhost/appli/api.php?DownVote/{id})
            if($_REQUEST['DownVote']>0){

                include('connexion.php'); //conn bdd

                
                $data = $conn->query("UPDATE article SET DownVote = DownVote+1 WHERE id=".$_REQUEST['DownVote']); //mise a jour d'une ligne de la table article dans la colonne upVote, ajout de 1 dans la ligne qui a l'id correspondant à l'article correspondant
            

                $conn = null; //fermeture conn bdd



                // echo"enlever 1 à l'article avec l'id " .$_REQUEST['downVote'];
            }else{
                echo"erreur";
            };
        }else{
            echo "erreur1";
        };
        break;

    case "DELETE":
        if(isset($_REQUEST['delete'])){//si le terme delete est présent dansd l'url  (mise en evidence dans postman pour l'instant).
            if($_REQUEST['delete']!=""){ //si delete est différent de null

                include('connexion.php'); //conn bdd 

                
                $data = $conn->query("DELETE FROM article WHERE id=".$_REQUEST['delete']); //(http://localhost/appli/api.php?delete/{id}

                // echo json_encode($data);
                echo "l'article avec l'id " .$_REQUEST['delete']."a été supprimé"; //message de confirmation de la suppression de l'article/

                $conn = null;//fermeture conn bdd


            }else{
                echo"l'article n'est pas supprimé";
            }
        }else{
            echo" erreur supprimé  ";
        };

        
        break;




    case "POST":
        if(isset($_POST['category']) && (isset($_POST['lireRSS']))){
            if($_POST['category']!="" && $_POST['lireRSS']!=""){
                
                $url = $_POST['lireRSS']; /* insérer ici l'adresse du flux RSS de votre choix */
                $category = $_POST['category'];

                $rss = simplexml_load_file($url);

                $source = $rss->channel->generator;

                include('connexion.php'); //conn bdd

                foreach ($rss->channel->item as $row){
                    
                    $titre = $row->title;
                    // echo "titre: " .$titre. "<br>";

                    $description = $row-> description;
                    // echo "description: " .$description. "<br>";
                    
                    $link= $row->link;
                    // echo "link: " .$link. "<br>";
                    
                    $enclosureType= $row->enclosure['type'];
                    // echo "enclosure type: " .$enclosureType. "<br>";

                    $enclosureUrl= $row->enclosure['url'];
                    // echo "enclosure url: " .$enclosureUrl. "<br>";

                   
                    // echo "source: " .$source. "<br>";

                    // echo "url " .$url. "<br>";
                // };
                    
                    $requete = "INSERT INTO article ( Title , Category , Description , Url ,EnclosureType , EnclosureUrl , Source , UpVote  , DownVote   ) VALUES( ? ,?, ?, ?, ? ,? ,? ,? ,? )";
                
                    $resultat = $conn -> prepare($requete);
                    $resultat -> execute ( array($titre, $category, $description,  $link, $enclosureType, $enclosureUrl, $source, 0, 0 ) );

                };
                    //echo json_encode($row);

                $conn = null;  
                // echo" recuperation flux rss sur l'url". $_POST['lireRSS']."et avec la categorie". $_POST['category'];
            }else{
                echo"erreur1";
            };
        }else{
            echo"erreur2";
        };
       break;

    default :
        echo 'la valeur de la request methode est' . $method;
};

?>