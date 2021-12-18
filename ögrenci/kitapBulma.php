<?php
session_start();
include "conn.php";

if(isset($_POST["listele"])) 
{
    if  (($_POST["authorId"] == 0) && ( $_POST["categoyId"] != 0)) {
    $sql = "SELECT book.id,book.name,author.authorName,book.totalPage,book.bookPrice,category.categoryName FROM book inner JOIN category ON book.categoyId = category.id inner JOIN author ON book.authorId = author.id  WHERE categoyId = ?";
    $sorgu = $baglan->prepare($sql);
    $sorgu->execute([

          
            $_POST["categoyId"]
            
            
        ]);
    }
    else if (($_POST["categoyId"] == 0 )&& ( $_POST["authorId"] != 0)){

        $sql = "SELECT book.id,book.name,author.authorName,book.totalPage,book.bookPrice,category.categoryName FROM book inner JOIN category ON book.categoyId = category.id inner JOIN author ON book.authorId = author.id  WHERE authorId = ?";
        $sorgu = $baglan->prepare($sql);
        $sorgu->execute([
        
            $_POST["authorId"]
           
            
            
        ]);
    }

    else if (($_POST["categoyId"] == 0) && ( $_POST["authorId"] == 0) ){

        $sql = "SELECT book.id,book.name,author.authorName,book.totalPage,book.bookPrice,category.categoryName FROM book inner JOIN category ON book.categoyId = category.id inner JOIN author ON book.authorId = author.id ";
        $sorgu = $baglan->prepare($sql);
        $sorgu->execute([
        
            $_POST["authorId"],
            $_POST["categoyId"]
           
            
            
        ]);
    }



    else {
        $sql = "SELECT book.id,book.name,author.authorName,book.totalPage,book.bookPrice,category.categoryName FROM book inner JOIN category ON book.categoyId = category.id inner JOIN author ON book.authorId = author.id  WHERE authorId = ? AND categoyId = ?";
            $sorgu = $baglan->prepare($sql);
        $sorgu->execute([
            $_POST["authorId"],
            $_POST["categoyId"]
            
            
        ]);
    }

      
}


else {
    $sql = "SELECT book.id,book.name,author.authorName,book.totalPage,book.bookPrice,category.categoryName FROM book inner JOIN category ON book.categoyId = category.id inner JOIN author ON book.authorId = author.id ";
$sorgu = $baglan->prepare($sql);
$sorgu->execute();
}


$sqlCat = "SELECT * FROM category";
$sorguCAT = $baglan->prepare($sqlCat);
$sorguCAT->execute();

$sqlAuthor = "SELECT * FROM author";
$sorguAuthor = $baglan->prepare($sqlAuthor);
$sorguAuthor->execute();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Öğrenci Bilgi Ekranı</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>

<body>

    <header>
    <div class="container">
            <div class="row">
                <h1 class="display-1 text-center">Kitap Detay Ekranı</h1>
            </div>
            <form action="" method="post">
            <div class="row">
                <div class="col">
                    <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="studentHome.php" class="btn btn-outline-primary">Ana Sayfa</a>
                        <a href="kitapBulma.php" class="btn btn-outline-primary">Tüm Kitaplar</a>
                        <p class="">kategori </p>
                        <select class="form-select" name="categoyId">
                            <option selected value="0"> Kategori seç</option>
                        <?php while ($satirCAT = $sorguCAT->fetch(PDO::FETCH_ASSOC)){
                                  ?>
                                   <option name="opt1" value="<?= $satirCAT["id"]?>"><?= $satirCAT["categoryName"]?> </option>
                                   <?php

                               }         
                               ?>
                        </select>
                        <p class="">yazar </p>
                        <select class="form-select" name="authorId">
                            <option selected value="0"> Yazar seç</option>
                               <?php while ($satirAuthor = $sorguAuthor->fetch(PDO::FETCH_ASSOC)){
                                   ?>
                                   <option name="opt2" value="<?= $satirAuthor["id"]?>"><?= $satirAuthor["authorName"]?></option>
                                   <?php

                               }         
                               ?>
                                </select>  
                            <button type="submit" name="listele" class="btn btn-primary mt-4">Listele</button>
                                <script type="text/javascript">$("#TablePart").load(document.URL +  ' #TablePart')</script>

                    </div>
                   
                </div>
            </div>
             </form>
        </div>

    </header>

    <main>
        <div class="container">
            <div class="row mt-4">
                <div class="col" >
                    <table  id="TablePart" class="table table-hover table-dark table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Name</th>
                                <th scope="col">Author Name</th>
                                <th scope="col">Category Name</th>
                                <th scope="col">Total Page</th>
                                <th scope="col">Book Price</th>
                                <th scope="col">İşlemler</th>

                            </tr>
                        </thead>
                        <tbody >
                            <?php while ($satir = $sorgu->fetch(PDO::FETCH_ASSOC)) { ?>
                               <!--  
                                    ->fetch ile her seferinde veri getiriliyor databaseden
                                    PDO::FETCH_ASSOC veri başlıklarını sırayla alıyor
                                    ör: id,name,email...
                                -->
                                <tr>
                                    <th scope="row"><?= $satir['id'] ?></th>
                                    <td><?= $satir['name'] ?></td>
                                    <td><?= $satir['authorName'] ?></td>
                                    <td><?= $satir['categoryName'] ?></td>
                                    <td><?= $satir['totalPage'] ?></td>
                                    <td><?= $satir['bookPrice'] ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <!-- detay sayfasında id si istenen idye sahip kişinin bilgisi -->
                                            <a href="kitapDetay.php?id=<?= $satir['id'] ?>" class="btn btn-success">Detay</a>
                                            
                                            
                                        </div>
                                    </td>
                                </tr>

                            <?php } 
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <footer></footer>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>

</html>