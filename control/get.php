<?php 
include("../classes/include.php");
$database_class = new DatabaseClass;
session_start();
//Personel ekleme
if(isset($_POST["personelarray"])){
    $datalar = json_decode($_POST["personelarray"]);
    $database_class->InsertKullanici($datalar[0],$datalar[1],$datalar[2],$datalar[3],$datalar[4],$datalar[5],$datalar[6],$datalar[7]);
    $sonuc["personel_basarili"] = "Personel başarılı bir şekilde eklendi!";
}
//Sisteme Kullanıcı ekleme
if(isset($_POST["datalar"])){
   $datas = json_decode($_POST["datalar"]);
   if($database_class->CheckSistemKullanici($datas[2]) > 0){
    $sonuc["this_user_already"] = "Bu kullanıcı zaten sisteme kayıtlı! Lütfen başka bir kullanıcı adı deneyin!";
   }else{
    $HashPassword = password_hash($datas[3], PASSWORD_BCRYPT);
    $database_class->InsertSistemKullanici($datas[0],$datas[1],$datas[2],$HashPassword,$datas[4],$_SESSION["nick"],date("Y-m-d H:i:s"));
    $sonuc["basarili_geldi"]= "Sisteme kullanıcı başarılı bir şekilde eklendi!";
   } 
}
// GİRİŞ KONTROLLERİ
if(isset($_POST["nickname"])){
    $nickname = $_POST["nickname"];
    $password = $_POST["password"];
   $status = $database_class->LoginSistemKullanici($nickname,$password);
   $sonuc["login_error_kullanici_yok"]= $status;
    if($status == 0){
        $sonuc["login_error_kullanici_yok"]= "Böyle bir kullanıcı sistemde kayıtlı değil!";
    }else if ($status == 1){
        $sonuc["login_success"]= "Giriş Yapıldı!";
        $_SESSION["nick"] = $nickname;        
    }else if ($status == 2){
        $sonuc["login_error_password"]= "Kullanıcı şifresi yanlış!";
    }
}

//ÇIKIŞ YAP
if(isset($_POST["sessionid"])){
    $sonuc["sessionid"] = $_POST["sessionid"];
    session_destroy();
}
//Kategori Ekleme
if(isset($_POST["kategori_isim"])){
    $kategori_isim = post("kategori_isim");
    $StatusForCheck = $database_class->CheckCategory($kategori_isim,"",1);
    if($StatusForCheck > 0){
        $database_class->AddCategory($kategori_isim);
        $sonuc["kategori_basarili"]= "Kategori başarılı bir şekilde eklendi!";
    }else if ($StatusForCheck == 0){
        $sonuc["category_already_added"] = "Kategori verisi veritabanında zaten kayıtlı!";
    }
}
//Kategori silme
if(isset($_POST["categoryId"])){
    $categoryID = post("categoryId");
    $checkCategory = $database_class->CheckCategory("",$categoryID,0);
    if($checkCategory < 1){
        $DeleteData = $database_class->DeleteCategory($categoryID);
        if($DeleteData == 1){
            $sonuc["kategori_silme_basarili"]= "Kategori başarılı bir şekilde silindi!";
        }else{
            $sonuc["kategori_silme_basarisiz"]= "Kategori silinirken bir hata oluştu!";
        }
    }
    }
    if(isset($_POST["Roledata"])){
        $RoleData = post("Roledata");
        $checkRoleData = $database_class->CheckRoleData($RoleData);
        if($checkRoleData == 0){
            $addRoleData = $database_class->AddRoleData($RoleData);
            if($addRoleData == 1){
                $sonuc["AddedRoleData"] = "Rol başarılı bir şekilde eklendi!";
            }
            else{
                $sonuc["RoleError"] = "Rol eklenilirken bir hata oluştu!";
            }
        }else{
            $sonuc["alreadyRoleData"]="Bu isme sahip bir rol zaten var!";
        }
        
    }
    if(isset($_POST["rol_id"])){
        $rol_id = post("rol_id");
        $rowcountdata = $database_class->CheckRols($rol_id);
        if($rowcountdata == 1){
            $deleteroldata= $database_class->DeleteRole($rol_id);
            if($deleteroldata == 1){
                $sonuc["rol_success_deleted"] = "Rol Başarılı bir şekilde silindi!";
                
            }
            else{
                $sonuc["rol_error_deleted"] = "Rol silinirken bir hata oluştu!";
            }
        }
        else{
            $sonuc["no_role"] = "Bu ID'ye sahip bir rol yok!";
        }
    }
    if(isset($_POST["reviewid"])){
        $reviewid = post("reviewid");
        $data = $database_class->GetPersonelProperties($reviewid);
        if($data != 0){
            $sonuc["reviewbasarili"] = $data;
        }
        else{
            $sonuc["reviewbasarisiz"]= "Data bulunamadı!";
        }
    }
    // if(isset($_POST["system_user_id"])){
    //     $system_user_id = post("system_user_id");
    //     $CheckSystemUser = $database_class->CheckSistemKullanici()
    //     if($checkCategory < 1){
    //         $DeleteData = $database_class->DeleteCategory($categoryID);
    //         if($DeleteData == 1){
    //             $sonuc["kategori_silme_basarili"]= "Kategori başarılı bir şekilde silindi!";
    //         }else{
    //             $sonuc["kategori_silme_basarisiz"]= "Kategori silinirken bir hata oluştu!";
    //         }
    //     }
    //     }
        if(isset($_POST["personel_id"])){
            $id = post("personel_id");
            $status = $database_class->DeletePersonel($id);
            if($status == 1){
                $sonuc["personel_delete_success"] = "Personel başarılı bir şekilde silindi!";
            }else{
                $sonuc["personel_delete_error"] = "Personel silinirken bir hata oluştu!";
            }
        }
        if(isset($_POST["duyuru_text"])){
            $duyuru_text = post("duyuru_text");
            $status_duyuru = $database_class->UpdateDuyuru($duyuru_text);
            if($status_duyuru == 1){
                $sonuc["duyuru_success"] = "Duyuru başarılı bir şekilde güncellendi!";
            }else{
                $sonuc["duyuru_error"] = "Duyuru güncellenirken bir hata oluştu!";
            }
        }
        if(isset($_POST["Object_Properties_Array"])){
           $object_data = json_decode($_POST["Object_Properties_Array"]);
            
        }
        if(isset($_POST["status_isim"])){
            $status_isim = post("status_isim");
            $CheckStatus = $database_class->CheckStatus(1,0,$status_isim);
            if($CheckStatus > 0){
                $sonuc["status_already_added"] = "Bu durum zaten veritabanında ekli!";
            }else if ($CheckStatus == 0){
                $database_class->AddStatus($status_isim);
                $sonuc["status_basarili"]= "Durum başarılı bir şekilde eklendi!";
            }
        }
echo json_encode($sonuc);
?>