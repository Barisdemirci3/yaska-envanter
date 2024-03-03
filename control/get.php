<?php
use Verot\Upload\Upload;
require_once("../vendor/autoload.php");
include("../classes/include.php");
$database_class = new DatabaseClass;
$user_interface = new CheckUserInterface;
error_reporting(0);
//Personel ekleme
if (isset($_POST["personelarray"])) {
    if($user_interface->SystemUserPermission($_SESSION["sistem_k_rol"]) != 1){
        $sonuc["yetki_error"] = $user_interface->SystemUserPermission($_SESSION["sistem_k_rol"]);
    }
    else{
    $datalar = json_decode($_POST["personelarray"]);
    $database_class->InsertKullanici($datalar[0], $datalar[1], $datalar[2], $datalar[3], $datalar[4], $datalar[5], $datalar[6], $datalar[7]);
    $sonuc["personel_basarili"] = "Personel başarılı bir şekilde eklendi!";
    }
}
//Sisteme Kullanıcı ekleme
if (isset($_FILES["file"]) || isset($_POST["password"])) {
    if($user_interface->SystemUserPermission($_SESSION["sistem_k_rol"]) != 1){
        $sonuc["yetki_error"] = $user_interface->SystemUserPermission($_SESSION["sistem_k_rol"]);
    }
    else{
    $image_path = "/images/profiles/user.png";
    $datas = array(post("name"), post("surname"), post("nickname"), post("password"), post("rol"));
    if ($database_class->CheckSistemKullanici($datas[2]) > 0) {
        $sonuc["this_user_already"] = "Bu kullanıcı zaten sisteme kayıtlı! Lütfen başka bir kullanıcı adı deneyin!";
    } else {
        $HashPassword = password_hash($datas[3], PASSWORD_BCRYPT);
        $handle = new Upload($_FILES["file"], "tr_TR");
        if($handle->uploaded){
            if($handle->file_src_name_ext != "jpg" && $handle->file_src_name_ext != "jpeg" && $handle->file_src_name_ext != "png"){
                $sonuc["image_error"] = "Lütfen sadece jpg, jpeg ve png  uzantılı dosyalar yükleyin!";
                echo json_encode($sonuc);
                return false;
            }
            else{
            $handle->file_new_name_body = RandomGenerateChar();
            $handle->image_resize = true;
            $handle->image_x = 75;
            $handle->image_y = 75;
            $handle->process("../images/profiles/");
            if($handle->processed){
                $image_path = "images/profiles/".$handle->file_dst_name;
                $handle->clean();
            }
            else{
                $sonuc["image_error"] = $handle->error;
                echo json_encode($sonuc);
                return false;
            }
        }
        }
        $database_class->InsertSistemKullanici($datas[0], $datas[1], $datas[2], $HashPassword, $datas[4], $_SESSION["nick"], $image_path);
        $sonuc["basarili_geldi"] = "Sisteme kullanıcı başarılı bir şekilde eklendi!";
        echo json_encode($sonuc);
        return false;
    }
}
}
// Login İşlemleri
if (isset($_POST["login_nickname"])) {
    $nickname = $_POST["login_nickname"];
    $password = $_POST["login_password"];
    $status = $database_class->LoginSistemKullanici($nickname, $password);
    $sonuc["login_error_kullanici_yok"] = $status;
    if ($status == 0) {
        $sonuc["login_error_kullanici_yok"] = "Böyle bir kullanıcı sistemde kayıtlı değil!";
    } else if ($status !== 1 && $status !== 2) {
        $status = json_decode($status, true);
        $sonuc["login_success"] = "Giriş Yapıldı!";
        $_SESSION["nick"] = $nickname;
        $_SESSION["sistem_k_rol"] = $status["sistem_k_rol"];
        $_SESSION["sistem_k_id"] = $status["sistem_k_id"];
       
    } else if ($status == 2) {
        $sonuc["login_error_password"] = "Kullanıcı şifresi yanlış!";
    }
}
//ÇIKIŞ YAP
if (isset($_POST["sessionid"])) {
    $sonuc["sessionid"] = $_POST["sessionid"];
    session_destroy();
}

//Kategori silme
if (isset($_POST["categoryId"])) {
    if($user_interface->SystemUserPermission($_SESSION["sistem_k_rol"]) != 1){
        $sonuc["yetki_error"] = $user_interface->SystemUserPermission($_SESSION["sistem_k_rol"]);
    }
    else{
    $categoryID = post("categoryId");
    $checkCategory = $database_class->CheckCategory("", $categoryID, 0);
    if ($checkCategory < 1) {
        $DeleteData = $database_class->DeleteCategory($categoryID);
        if ($DeleteData == 1) {
            $sonuc["kategori_silme_basarili"] = "Kategori başarılı bir şekilde silindi!";
        } else {
            $sonuc["kategori_silme_basarisiz"] = "Kategori silinirken bir hata oluştu!";
        }
    }
    }
}
//Kategori Ekleme
if (isset($_POST["kategori_isim"])) {
    if($user_interface->SystemUserPermission($_SESSION["sistem_k_rol"]) != 1){
        $sonuc["yetki_error"] = $user_interface->SystemUserPermission($_SESSION["sistem_k_rol"]);
    }
    else{
    $kategori_isim = post("kategori_isim");
    $StatusForCheck = $database_class->CheckCategory(1, $kategori_isim, "");
    if ($StatusForCheck > 0) {
        $database_class->AddCategory($kategori_isim);
        $sonuc["kategori_basarili"] = "Kategori başarılı bir şekilde eklendi!";
    } else if ($StatusForCheck == 0) {
        $sonuc["category_already_added"] = "Kategori verisi veritabanında zaten kayıtlı!";
    }
}
}
// ROL EKLEME
if (isset($_POST["Roledata"])) {
    if($user_interface->SystemUserPermission($_SESSION["sistem_k_rol"]) != 1){
        $sonuc["yetki_error"] = $user_interface->SystemUserPermission($_SESSION["sistem_k_rol"]);
    }
    else{
    $RoleData = post("Roledata");
    $checkRoleData = $database_class->CheckRoleData($RoleData);
    if ($checkRoleData == 0) {
        $addRoleData = $database_class->AddRoleData($RoleData);
        if ($addRoleData == 1) {
            $sonuc["AddedRoleData"] = "Rol başarılı bir şekilde eklendi!";
        } else {
            $sonuc["RoleError"] = "Rol eklenilirken bir hata oluştu!";
        }
    } else {
        $sonuc["alreadyRoleData"] = "Bu isme sahip bir rol zaten var!";
    }
}
}
// ROL SİLME
if (isset($_POST["rol_id"])) {
    if($user_interface->SystemUserPermission($_SESSION["sistem_k_rol"]) != 1){
        $sonuc["yetki_error"] = $user_interface->SystemUserPermission($_SESSION["sistem_k_rol"]);
    }
    else{
    $rol_id = post("rol_id");
    $rowcountdata = $database_class->CheckRols($rol_id);
    if ($rowcountdata == 1) {
        $deleteroldata = $database_class->DeleteRole($rol_id);
        if ($deleteroldata == 1) {
            $sonuc["rol_success_deleted"] = "Rol Başarılı bir şekilde silindi!";
        } else {
            $sonuc["rol_error_deleted"] = "Rol silinirken bir hata oluştu!";
        }
    } else {
        $sonuc["no_role"] = "Bu ID'ye sahip bir rol yok!";
    }
}
}
// Review Gösterme
if (isset($_POST["reviewid"])) {
    $reviewid = post("reviewid");
    $data = $database_class->GetPersonelProperties($reviewid);
    if ($data != 0) {
        $sonuc["reviewbasarili"] = $data;
    } else {
        $sonuc["reviewbasarisiz"] = "Data bulunamadı!";
    }
}
if(isset($_POST["system_user_id"])){
    if($user_interface->SystemUserPermission($_SESSION["sistem_k_rol"]) != 1){
        $sonuc["yetki_error"] = $user_interface->SystemUserPermission($_SESSION["sistem_k_rol"]);
    }else{
    $system_user_id = post("system_user_id");
    $feedback_value_for_delete = $database_class->GetUserPropertiesFromIDForDelete($system_user_id);
    if($feedback_value_for_delete == 1){
        $sonuc["feedback_success"] = "Kullanıcı başarılı bir şekilde silindi!";
    }
    else if($feedback_value_for_delete == 0){
        $sonuc["feedback_error"] = "Kullanıcı silinirken bir hata oluştu!";
    }
    else{
        $sonuc["feedback_error"] = "Kullanıcı bulunamadı!";
    
    }
}
}
    //Personel Silme
if (isset($_POST["personel_id"])) {
    if($user_interface->SystemUserPermission($_SESSION["sistem_k_rol"]) != 1){
        $sonuc["yetki_error"] = $user_interface->SystemUserPermission($_SESSION["sistem_k_rol"]);
    }
    else{
    $id = post("personel_id");
    $status = $database_class->DeletePersonel($id);
    if ($status == 1) {
        $sonuc["personel_delete_success"] = "Personel başarılı bir şekilde silindi!";
    } else {
        $sonuc["personel_delete_error"] = "Personel silinirken bir hata oluştu!";
    }
}
}
//Duyuru Güncelleme
if (isset($_POST["duyuru_text"])) {
    if($user_interface->SystemUserPermission($_SESSION["sistem_k_rol"]) != 1){
        $sonuc["yetki_error"] = $user_interface->SystemUserPermission($_SESSION["sistem_k_rol"]);
    }
    else{
    $duyuru_text = post("duyuru_text");
    $status_duyuru = $database_class->UpdateDuyuru($duyuru_text);
    if ($status_duyuru == 1) {
        $sonuc["duyuru_success"] = "Duyuru başarılı bir şekilde güncellendi!";
    } else {
        $sonuc["duyuru_error"] = "Duyuru güncellenirken bir hata oluştu!";
    }
}
}
//Cihaz Ekleme
if (isset($_POST["Object_Properties_Array"])) {
    if($user_interface->SystemUserPermission($_SESSION["sistem_k_rol"]) != 1){
        $sonuc["yetki_error"] = $user_interface->SystemUserPermission($_SESSION["sistem_k_rol"]);
    }
    else{
    $object_data = json_decode($_POST["Object_Properties_Array"]);
    if ($object_data != "") {
        $object_add_status = $database_class->AddObjectToDatabase($object_data[0], $object_data[1], $object_data[2], $object_data[3], $_SESSION["sistem_k_id"], $object_data[4]);
        if ($object_add_status == 1) {
            $sonuc["object_success_added"] = "Cihaz başarılı bir şekilde eklendi!";
        } else {
            $sonuc["object_error"] = "Cihaz eklenirken bir hata oluştu!";
        }
    } else {
        $sonuc["object_id_empty"] = "Gelen ID boş!";
    }
}
}
//Durum Ekleme
if (isset($_POST["status_isim"])) {
    if($user_interface->SystemUserPermission($_SESSION["sistem_k_rol"]) != 1){
        $sonuc["yetki_error"] = $user_interface->SystemUserPermission($_SESSION["sistem_k_rol"]);
    }
    else{
    $status_isim = post("status_isim");
    $CheckStatus = $database_class->CheckStatus(1, 0, $status_isim);
    if ($CheckStatus > 0) {
        $sonuc["status_already_added"] = "Bu durum zaten veritabanında ekli!";
    } else if ($CheckStatus == 0) {
        $database_class->AddStatus($status_isim);
        $sonuc["status_basarili"] = "Durum başarılı bir şekilde eklendi!";
    }
}
}
//Durum Silme
if (isset($_POST["button_value"])) {
    if($user_interface->SystemUserPermission($_SESSION["sistem_k_rol"]) != 1){
        $sonuc["yetki_error"] = $user_interface->SystemUserPermission($_SESSION["sistem_k_rol"]);
    }
    else{
    $button_value = post("button_value");
    if ($button_value == "" || $button_value == null) {
        $sonuc["button_value_empty"] = "Gelen data boş!";
    } else {
        $status_value = $database_class->StatusDelete($button_value);
        if ($status_value == 1) {
            $sonuc["durum_silme_basarili"] = "Durum başarılı bir şekilde silindi!";
        } else {
            $sonuc["durum_silme_basarisiz"] = "Durum silinirken bir hata oluştu!";
        }
    }
}
}
//Durum value gösterme
if (isset($_POST["button_value_object"])) {
    $button_value_object = post("button_value_object");
    if ($button_value_object == "" || $button_value_object == null) {
        $sonuc["button_object_value_empty"] = "Gelen data boş!";
    } else {
        $data = $database_class->GetObjects(1, $button_value_object);
        if ($data != "") {
            $name = $database_class->CheckUser($data["esya_ekleyen_id"]);
            $status_name = $database_class->GetStatusName($data["esya_durumu"]);
            $kategori_name = $database_class->GetCategoryName($data["esya_kategori_id"]);
            if(is_array($status_name)){
                $data["esya_durum_name"] = $status_name["durum_isim"];
            }
            else{
                $data["esya_durum_name"] = "Durum bulunamadı!";
            }
            if(is_array($kategori_name)){
                $data["esya_kategori_name"] = $kategori_name["kategori_isim"];
            }
            else{
                $data["esya_kategori_name"] = "Kategori bulunamadı!";
            }
            if(is_array($name)){
                $data["esya_ekleyen_nickname"] = $name["sistem_k_kullaniciadi"];
            }
            else{
                $data["esya_ekleyen_nickname"] = "Kullanıcı bulunamadı!";
            }
            $get_personel_nickname = $database_class->GetPersonelProperties($data["esya_ait_personel_id"]);
            $data["esya_ait_personel_isim_soyisim"] =  CharUpper($get_personel_nickname["kullanici_isim"]). " " . CharUpper($get_personel_nickname["kullanici_soyisim"]);
            $sonuc["object_review_success"] = $data;
        } else {
            $sonuc["object_review_error"] = "Data bulunamadı!";
        }
    }
}
//Cihaz Silme
if(isset($_POST["button_delete_id"])){
    if($user_interface->SystemUserPermission($_SESSION["sistem_k_rol"]) != 1){
        $sonuc["yetki_error"] = $user_interface->SystemUserPermission($_SESSION["sistem_k_rol"]);
    }
    else{
    $button_delete_id = post("button_delete_id");
    $status_object = $database_class->DeleteObject($button_delete_id);
    if($status_object == 1){
        $sonuc["object_delete_success"] = "Cihaz başarılı bir şekilde silindi!";
    }else{
        $sonuc["object_delete_error"] = "Cihaz silinirken bir hata oluştu!";
    }
}
}
//Kategori Güncelleme
if(isset($_POST["text_category"]) && isset($_POST["category_edit_id"])){
    $text_category = post("text_category");
    $category_edit_id = post("category_edit_id");
    if((int)$text_category){
        $sonuc["category_update_error"] = "Kategori ismi sadece rakamlardan oluşamaz!";
    }else{
    $update_category = $database_class->UpdateCategory($category_edit_id, $text_category);
    if($update_category == 1){
        $sonuc["category_update_success"] = "Kategori başarılı bir şekilde güncellendi!";
    }
    else{
        $sonuc["category_update_error"] = "Kategori güncellenirken bir hata oluştu!";
    }
}
}
//Durum Güncelleme
if(isset($_POST["status_edit_id"]) && isset($_POST["text_status"])){
    $status_edit_id = post("status_edit_id");
    $text_status = post("text_status");
    if((int)$text_status){
        $sonuc["status_update_error"] = "Durum ismi sadece rakamlardan oluşamaz!";
    }else{
    $update_status = $database_class->UpdateStatus($status_edit_id, $text_status);
    if($update_status == 1){
        $sonuc["status_update_success"] = "Durum başarılı bir şekilde güncellendi!";
    }
    else{
        $sonuc["status_update_error"] = "Durum güncellenirken bir hata oluştu!";
    }
}
}
if(isset($_POST["text_rol"]) && isset($_POST["rol_edit_id"])){
    $text_rol = post("text_rol");
    $rol_edit_id = post("rol_edit_id");
    if((int)$text_rol){
        $sonuc["rol_update_error"] = "Rol ismi sadece rakamlardan oluşamaz!";
    }else{
    $update_rol = $database_class->UpdateRol($rol_edit_id, $text_rol);
    if($update_rol == 1){
        $sonuc["rol_update_success"] = "Rol başarılı bir şekilde güncellendi!";
    }
    else{
        $sonuc["rol_update_error"] = "Rol güncellenirken bir hata oluştu!";
    }
}
}
echo json_encode($sonuc);
