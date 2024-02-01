<?php
function post($post)
{
    return htmlspecialchars(trim($_POST[$post]));
}
function CheckSpace($string){
   if(trim($string) == "" || trim($string) == null){
        return "Bilgi yok.";
   } 
   else{
    return $string;
   }
}
class DatabaseClass {
    public $db; 

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=envanter-takip', "root", "root");
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    function InsertKullanici($ad, $soyad, $callintech, $callintech_sifre, $mailsender, $mailsender_sifre, $slack_mail, $rol){
        $create = $this->db->prepare("INSERT INTO kullanicilar (kullanici_isim, kullanici_soyisim, kullanici_callintech , kullanici_callintech_sifre , kullanici_mailsender, kullanici_mailsender_sifre , kullanici_slack_mail , kullanici_rol, kullanici_eklenme_tarihi) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $create->execute([$ad, $soyad, $callintech, $callintech_sifre, $mailsender, $mailsender_sifre, $slack_mail, $rol,date("Y-m-d H:i:s") ]);
        if($create){
           
        }else{
           
        }
    }
    function CheckSistemKullanici($nickname,$checkno = 1){
        if($checkno == 1){
        $checkSystem = $this->db->prepare("SELECT * FROM sistem_kullanici WHERE sistem_k_kullaniciadi = ?");
        $checkSystem->execute([$nickname]);
        return $checkSystem->rowCount(); // Kullanıcı var mı yok mu?
        }
        else if ($checkno == 0){
            $checkSystem = $this->db->query("SELECT * FROM sistem_kullanici")->fetchAll(PDO::FETCH_ASSOC);
            return $checkSystem;
        }
    }
    function InsertSistemKullanici($isim,$soyisim,$kullaniciadi,$sifre,$rol,$kimekledi,$kayittarihi){
        $createUser = $this->db->prepare("INSERT INTO sistem_kullanici (sistem_k_isim , sistem_k_soyisim , sistem_k_kullaniciadi  ,sistem_k_sifre , sistem_k_rol , sistem_k_kimekledi , sistem_k_kayittarihi) VALUES (?, ?, ?, ?, ?, ?, ?) ");
        $createUser->execute([$isim,$soyisim,$kullaniciadi,$sifre,$rol,$kimekledi,date("Y-m-d H:i:s")]);
        if($createUser){
            $createUser = null;
            return "Kullanıcı başarılı bir şekilde oluşturuldu!";
        }else{
            $createUser = null;
            return "Kullanıcı oluşturulurken bir hata oluştu!";
        }
       
    }
    function LoginSistemKullanici($nickname, $password){
        $loginCheck = $this->db->prepare("SELECT * FROM sistem_kullanici WHERE sistem_k_kullaniciadi = ?");
        $loginCheck->execute([$nickname]);
        if ($loginCheck->rowCount() <= 0) {
            return 0; // Kullanıcı yoksa 0 dönecek
        } else {
            $loginCheckWrite = $loginCheck->fetch(PDO::FETCH_ASSOC);
            if ($loginCheckWrite !== false) {
                // Şifre doğrulaması
                $password_status = password_verify($password, $loginCheckWrite["sistem_k_sifre"]);
                if ($password_status) {
                    return 1; // Şifre doğru ise 1 dönecek ve giriş yapılacak
                } else {
                    return 2; // Şifre yanlış ise 2 dönecek ve giriş yapılmayacak
                }
            } else {
                return 0; // Kullanıcı bulunamadı veya başka bir hata oluştu
            }
        }
    }
    function GetUserProperties($sessionNick) {
        $CreateQuery = $this->db->prepare("SELECT * FROM sistem_kullanici WHERE sistem_k_kullaniciadi = ?");
        $CreateQuery->execute([$sessionNick]);
        $WriteQuery = $CreateQuery->fetch(PDO::FETCH_ASSOC);
        return $WriteQuery;
    }
    function GetPersonel($SelectCountOrNot){
        $CreateQuery = $this->db->prepare("SELECT * FROM kullanicilar");
        $CreateQuery->execute();
        if($SelectCountOrNot == 1){
            return $CreateQuery->rowCount();
        }else if($SelectCountOrNot == 0){
          $WriteQuery = $CreateQuery->fetchAll(PDO::FETCH_ASSOC);
          return $WriteQuery;
        }     
    }
    function AddCategory($kategori_isim){
        $CreateQuery = $this->db->prepare("INSERT INTO kategoriler SET kategori_isim = ?");
        $CreateQuery->execute([$kategori_isim]);
        if($CreateQuery){
            return 1;
        }
        else{
            return 0;
        }
    }
    function GetCategory(){
        $CreateQuery = $this->db->prepare("SELECT * FROM kategoriler");
        $CreateQuery->execute();
        $WriteQuery = $CreateQuery->fetchAll(PDO::FETCH_ASSOC);
        return $WriteQuery;        
    }
    function CheckCategory($check_no,$kategori_isim = "", $kategori_id = ""){
        if ($check_no == 1 && $kategori_isim != "") {
            $CreateQuery = $this->db->prepare("SELECT * FROM kategoriler WHERE kategori_isim = ?");
            $CreateQuery->execute([$kategori_isim]);
            return $CreateQuery->rowCount() > 0 ? 0 : 1; // Kategori varsa 0, yoksa 1 döner
        } else if ($check_no == 0 && $kategori_id != "") {
            $CreateQuery = $this->db->prepare("SELECT * FROM kategoriler WHERE kategori_id = ?");
            $CreateQuery->execute([$kategori_id]);
            return $CreateQuery->rowCount() > 0 ? 0 : 1; // Kategori varsa 0, yoksa 1 döner
        }
        return -1; // Eğer gerekli koşullar sağlanmazsa -1 dön
    }
    function DeleteCategory($kategori_id){
        $CreateQuery = $this->db->prepare("DELETE FROM kategoriler WHERE kategori_id = ?");
        $CreateQuery->execute([$kategori_id]);
        if($CreateQuery == true){
            return 1;//Çalıştı
        }else{
            return 0;//Çalışmadı
        }
    }
    function GetSystemUsers(){
        $CreateQuery = $this->db->prepare("SELECT * FROM sistem_kullanici");
        $CreateQuery->execute();
        $WriteQuery = $CreateQuery->fetchAll(PDO::FETCH_ASSOC);
        return $WriteQuery;
    }
    function CheckRoleData($rolename){
        $CreateQuery = $this->db->prepare("SELECT * FROM roller WHERE rol_name = ?");
        $CreateQuery->execute([$rolename]);
        if($CreateQuery->rowCount() < 1){
            return 0; // ROL YOK
        }else{
            return 1; // ROL VAR
        }
    }
    function AddRoleData($rolename){
        $CreateQuery = $this->db->prepare("INSERT INTO roller SET rol_name = ? ");
        $CreateQuery->execute([$rolename]);
        if($CreateQuery){
            return 1; //BAŞARILIYSA 1 Dönücek
        }else{
            return 0; //BAŞARISIZ İSE 0
        }
    }
    function GetRols(){
        $CreateQuery = $this->db->query("SELECT * FROM roller ");
        $WriteQuery = $CreateQuery->fetchAll(PDO::FETCH_ASSOC);
        return $WriteQuery;
    }
    function DeleteRole($role_id){
        $CreateQuery = $this->db->prepare("DELETE FROM roller WHERE rol_id = ?");
        $CreateQuery->execute([$role_id]);
        if($CreateQuery){
            return 1; //Başarılı
        }else{
            return 0; //Başarısız
        }
    }
    function CheckRols($role_id){
        $CreateQuery = $this->db->prepare("SELECT * FROM roller WHERE rol_id = ? ");
        $CreateQuery->execute([$role_id]);
        $RoleCount = $CreateQuery->rowCount();
        if($RoleCount > 0){
            return 1; //Rol var
        }
        else{
            return 0; // Rol yok
        }
    }
   function SystemRole($id){
    switch ($id) {
        case 0:
            return "Görüntüleyici";
            break;
        case 1:
            return "Düzenleyici";
            break;
        case 2:
            return "Yönetici";
            break;
        default:
            return "Böyle bir yetki yok!";
            break;
    }
    
   }
   function SystemDeleteUser($SystemUserId){
        $CreateQuery= $this->db->prepare("DELETE FROM sistem_kullanici WHERE sistem_kullanici_id = ?");
        $CreateQuery->execute([$SystemUserId]);
        if($CreateQuery){
            return 1; // Silindi
        }else{
            return 0; // Silinmedi
        }
    
   }
   function CheckUser($SystemUserId){
    $CreateQuery = $this->db->prepare("SELECT * FROM sistem_kullanici WHERE sistem_kullanici_id = ?");
    $CreateQuery->execute([$SystemUserId]);
   }
   function GetPersonelProperties($id){
    $CreateQuery = $this->db->prepare("SELECT * FROM kullanicilar WHERE kullanici_id = ? ");
    $CreateQuery->execute([$id]);
    if($CreateQuery){
        return $WriteQuery = $CreateQuery->fetchall(PDO::FETCH_ASSOC); //Başarılı
    }else{
        return 0; //Başarısız
    }
   }
   function DeletePersonel($id){
    $CreateQuery = $this->db->prepare("DELETE FROM kullanicilar WHERE kullanici_id = ? ");
    $CreateQuery->execute([$id]);
    if($CreateQuery){
        return 1; // Silme işlemi başarılı
    }else{
        return 0; //Silme işlemi başarısız
    }
   }
   function UpdateDuyuru($duyurutext){
    $CreateQuery = $this->db->prepare("UPDATE duyuru SET duyuru_text = ? , duyuru_date = ?");
    $CreateQuery->execute([$duyurutext,date("Y-m-d H:i:s")]);
    if($CreateQuery){
        return 1; //Başarıyla güncellendi
    }
    else{
        return 0; //Güncellenme başarısız
    }
   }
   function GetUpdateText(){
    $CreateQuery = $this->db->query("SELECT * FROM duyuru");    
    $WriteQuery = $CreateQuery->fetch(PDO::FETCH_ASSOC);
    return $WriteQuery;
   }
   function AddObjectToDatabase($seri_no, $kategori_, $aciklama, $durum, $ekleyen_kisi, $fotograf){
    
   }
   function AddStatus($statusName){
    $CreateQuery = $this->db->prepare("INSERT INTO durumlar SET durum_isim = ?");
    $CheckQuery = $CreateQuery->execute([$statusName]);
    if($CheckQuery){
        return 1; //Eklendi
    }else{
        return 0; //Eklenmedi
    }
   }
   function CheckStatus($check_no, $status_id = 0, $status_name = ""){
        if($check_no == 0){
            $CreateQuery_forid = $this->db->prepare("SELECT * FROM durumlar WHERE durum_id = ?");
            $CreateQuery_forid->execute([$status_id]);
            if($CreateQuery_forid->rowCount() > 0){
                return 1; // BU IDYE SAHİP DURUM VAR
            }
            else{
                return 0; // BU IDYE SAHİP DURUM YOK
            }
        }
        else if($check_no == 1){
            $CreateQuery_forname = $this->db->prepare("SELECT * FROM durumlar WHERE durum_isim = ?");
            $CreateQuery_forname->execute([$status_name]);
            if($CreateQuery_forname->rowCount() > 0){
                return 1; //BU İSME SAHİP BİR DURUM VAR
            }else{
                return 0; //BU İSME SAHİP BİR DURUM YOK
            }
        }
        else{
            $CreateQuery = $this->db->query("SELECT * FROM durumlar")->fetchAll(PDO::FETCH_ASSOC);
            return $CreateQuery;
        }
   }
}

?>
