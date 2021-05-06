<?php 
            $queryCount = $query; // recupere la query actuelle pour la modifier    
            $queryCount = str_replace('*', 'COUNT(DISTINCT vd_id) as nbResult', $queryCount);
            $perPage = 6;
            if(strpos($_SERVER['REQUEST_URI'], "historique")){
                $queryCount = explode("GROUP BY", $queryCount);
                $queryCount = $queryCount[0];
            }
            $nbResult = $conn->queryMultipleValue($queryCount, $params); // recupere le nombre total de resultat suite à la requete
            $nbPage = (int)ceil($nbResult[0]->nbResult/$perPage);
            if($nbPage == 0){
                require '../views/404.php';
                return;
            }

            if(isset($_GET['page']) && !empty($_GET['page'])){
                $currentPage =  (int)$_GET['page'] ?? 1;
            }
            else{ $currentPage = 1;}
            $linkAttribute = []; //array contenant les différents attributs des liens de page
                //preparation des attribut des liens pour les pages dynamiquement
            for($i=1; $i <= $nbPage; $i++) {
                $attribute = "?page=$i";
                array_push($linkAttribute, $attribute);
            }
            if($currentPage > $nbPage){
                $currentPage = $nbPage;
             }
             else if($currentPage < 1){
                 $currentPage = 1;
             }
            $offset = $perPage * ($currentPage-1);
            $query .= " LIMIT $perPage OFFSET $offset";
            $result = $conn->queryMultipleValue($query, $params); 

        //supprime ?page= de request uri pour le href des liens.
        // Sinon  linkAttribute s'ajoute à chaque fois dans l'URL
            if(strpos($_SERVER['REQUEST_URI'], "?page=")){
                $currentURL = substr($_SERVER['REQUEST_URI'], 0, -7);
            }
            else{
                $currentURL = $_SERVER['REQUEST_URI'];
            }
