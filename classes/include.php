<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
session_start();
if (!isset($_POST) || !isset($_GET)) {
    header("Location: ../index.php");
}
function Get($get){
    return htmlspecialchars(trim($_GET[$get]));
}
function post($post)
{
    return htmlspecialchars(trim($_POST[$post]));
}
function CheckSpace($string)
{
    if (trim($string) == "" || trim($string) == null) {
        return "Bilgi yok.";
    } else {
        return $string;
    }
}
function DateFormater($date)
{
    $date = new DateTime($date);
    return $date->format("d/m/Y H:i");
}
function CharUpper($string)
{
    $stringCount = strlen($string);
    $charupperstring =  strtoupper(substr($string, 0, 1));
    return $charupperstring . strtolower(substr($string, 1, $stringCount));
}
function RandomGenerateChar()
{
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $charsCount = strlen($chars);
    $randomChar = "";
    for ($i = 0; $i < 10; $i++) {
        $randomChar .= $chars[rand(0, $charsCount - 1)];
    }
    return $randomChar . rand(0, 1000);
}
class DatabaseClass
{
 function DateFormater($date)
{
    $date = new DateTime($date);
    return $date->format("d/m/Y H:i");
}
    public $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;dbname=envanter-takip', "root", "root");
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    function InsertKullanici($ad, $soyad, $callintech, $callintech_sifre, $mailsender, $mailsender_sifre, $slack_mail, $rol)
    {
        $create = $this->db->prepare("INSERT INTO kullanicilar (kullanici_isim, kullanici_soyisim, kullanici_callintech , kullanici_callintech_sifre , kullanici_mailsender, kullanici_mailsender_sifre , kullanici_slack_mail , kullanici_rol, kullanici_eklenme_tarihi) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $create->execute([$ad, $soyad, $callintech, $callintech_sifre, $mailsender, $mailsender_sifre, $slack_mail, $rol, date("Y-m-d H:i:s")]);
        if ($create) {
        } else {
        }
    }
    function CheckSistemKullanici($nickname, $checkno = 1)
    {
        if ($checkno == 1) {
            $checkSystem = $this->db->prepare("SELECT * FROM sistem_kullanici WHERE sistem_k_kullaniciadi = ?");
            $checkSystem->execute([$nickname]);
            return $checkSystem->rowCount(); // Kullanıcı var mı yok mu?
        } else if ($checkno == 0) {
            $checkSystem = $this->db->query("SELECT * FROM sistem_kullanici")->fetchAll(PDO::FETCH_ASSOC);
            return $checkSystem;
        }
    }
    function InsertSistemKullanici($isim, $soyisim, $kullaniciadi, $sifre, $rol, $kimekledi, $profil_fotografi)
    {
        $createUser = $this->db->prepare("INSERT INTO sistem_kullanici (sistem_k_profil , sistem_k_soyisim , sistem_k_kullaniciadi  ,sistem_k_sifre , sistem_k_rol , sistem_k_kimekledi , sistem_k_isim, sistem_k_kayittarihi) VALUES (?, ?, ?, ?, ?, ?, ?, ?) ");
        $createUser->execute([$profil_fotografi, $soyisim, $kullaniciadi, $sifre, $rol, $kimekledi, $isim, date("Y-m-d H:i:s")]);
        if ($createUser) {
            $createUser = null;
            return "Kullanıcı başarılı bir şekilde oluşturuldu!";
        } else {
            $createUser = null;
            return "Kullanıcı oluşturulurken bir hata oluştu!";
        }
    }
    function LoginSistemKullanici($nickname, $password)
    {
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
                    return json_encode($loginCheckWrite); // Şifre doğru ise logincheckwrite JSOn formatında dönücek dönecek ve giriş yapılacak
                } else {
                    return 2; // Şifre yanlış ise 2 dönecek ve giriş yapılmayacak
                }
            } else {
                return 0; // Kullanıcı bulunamadı veya başka bir hata oluştu
            }
        }
    }
    function GetUserProperties($sessionNick)
    {
        $CreateQuery = $this->db->prepare("SELECT * FROM sistem_kullanici WHERE sistem_k_kullaniciadi = ?");
        $CreateQuery->execute([$sessionNick]);
        $WriteQuery = $CreateQuery->fetch(PDO::FETCH_ASSOC);
        return $WriteQuery;
    }
    /**
     * Kullanıcı IDsine göre veritabanından silme işlemi yapar
     * @param int $id Kullanıcı idsi
     * @return int 1, 0, 2 döner. 1 başarılı, 0 başarısız, 2 kullanıcı bulunamadı
     */
    function GetUserPropertiesFromIDForDelete($id)
    {
        $CreateQuery = $this->db->prepare("SELECT * FROM sistem_kullanici WHERE sistem_k_id = ?");
        $CreateQuery->execute([$id]);
        if ($CreateQuery->rowCount() > 0) {
            $DeleteQuery = $this->db->prepare("DELETE FROM sistem_kullanici WHERE sistem_k_id = ?");
            $DeleteQuery->execute([$id]);
            if ($DeleteQuery) {
                return 1; //Başarılı bir şekilde silindi!
            } else {
                return 0; //Silinemedi
            }
        } else {
            return 2; //Kullanıcı bulunamadı
        }
    }
    /**
     * Kullanıcıların bilgilerini veya countu döndürür
     * @param int $SelectCountOrNot countu döndürmek istiyorsanız 1, kullanıcı bilgilerini döndürmek istiyorsanız 0
     * @return int 1, 0 döner. 1 başarılı, 0 başarısız
     */
    function GetPersonel($SelectCountOrNot)
    {
        $CreateQuery = $this->db->prepare("SELECT * FROM kullanicilar");
        $CreateQuery->execute();
        if ($SelectCountOrNot == 1) {
            return $CreateQuery->rowCount();
        } else if ($SelectCountOrNot == 0) {
            $WriteQuery = $CreateQuery->fetchAll(PDO::FETCH_ASSOC);
            return $WriteQuery;
        }
    }
    function AddCategory($kategori_isim)
    {
        $CreateQuery = $this->db->prepare("INSERT INTO kategoriler SET kategori_isim = ?");
        $CreateQuery->execute([$kategori_isim]);
        if ($CreateQuery) {
            return 1;
        } else {
            return 0;
        }
    }
    function GetCategory()
    {
        $CreateQuery = $this->db->prepare("SELECT * FROM kategoriler");
        $CreateQuery->execute();
        $WriteQuery = $CreateQuery->fetchAll(PDO::FETCH_ASSOC);
        return $WriteQuery;
    }
    function CheckCategory($check_no, $kategori_isim = "", $kategori_id = "")
    {
        if ($check_no == 1 && $kategori_isim != "") {
            $CreateQuery = $this->db->prepare("SELECT * FROM kategoriler WHERE kategori_isim = ?");
            $CreateQuery->execute([$kategori_isim]);
            return $CreateQuery->rowCount() > 0 ? 0 : 1; // Kategori varsa 0, yoksa 1 döner
        } else if ($check_no == 0 && $kategori_id != "") {
            $CreateQuery = $this->db->prepare("SELECT * FROM kategoriler WHERE kategori_id = ?");
            $CreateQuery->execute([$kategori_id]);
            return $CreateQuery->rowCount() > 0 ? 0 : 1; // Kategori varsa 0, yoksa 1 döner
        }
        return 1; // Eğer gerekli koşullar sağlanmazsa 1 dön
    }
    function DeleteCategory($kategori_id)
    {
        $CreateQuery = $this->db->prepare("DELETE FROM kategoriler WHERE kategori_id = ?");
        $CreateQuery->execute([$kategori_id]);
        if ($CreateQuery == true) {
            return 1; //Çalıştı
        } else {
            return 0; //Çalışmadı
        }
    }
    function GetSystemUsers()
    {
        $CreateQuery = $this->db->prepare("SELECT * FROM sistem_kullanici");
        $CreateQuery->execute();
        $WriteQuery = $CreateQuery->fetchAll(PDO::FETCH_ASSOC);
        return $WriteQuery;
    }
    function CheckRoleData($rolename)
    {
        $CreateQuery = $this->db->prepare("SELECT * FROM roller WHERE rol_name = ?");
        $CreateQuery->execute([$rolename]);
        if ($CreateQuery->rowCount() < 1) {
            return 0; // ROL YOK
        } else {
            return 1; // ROL VAR
        }
    }
    function AddRoleData($rolename)
    {
        $CreateQuery = $this->db->prepare("INSERT INTO roller SET rol_name = ? ");
        $CreateQuery->execute([$rolename]);
        if ($CreateQuery) {
            return 1; //BAŞARILIYSA 1 Dönücek
        } else {
            return 0; //BAŞARISIZ İSE 0
        }
    }
    function GetRols()
    {
        $CreateQuery = $this->db->query("SELECT * FROM roller ");
        $WriteQuery = $CreateQuery->fetchAll(PDO::FETCH_ASSOC);
        return $WriteQuery;
    }
    function DeleteRole($role_id)
    {
        $CreateQuery = $this->db->prepare("DELETE FROM roller WHERE rol_id = ?");
        $CreateQuery->execute([$role_id]);
        if ($CreateQuery) {
            return 1; //Başarılı
        } else {
            return 0; //Başarısız
        }
    }
    function CheckRols($role_id)
    {
        $CreateQuery = $this->db->prepare("SELECT * FROM roller WHERE rol_id = ? ");
        $CreateQuery->execute([$role_id]);
        $RoleCount = $CreateQuery->rowCount();
        if ($RoleCount > 0) {
            return 1; //Rol var
        } else {
            return 0; // Rol yok
        }
    }
    function SystemRole($id)
    {
        switch ($id) {
            case 0:
                return "Görüntüleyici";
                break;
            case 1:
                return "Moderatör";
                break;
            case 2:
                return "Yönetici";
                break;
            default:
                return "Böyle bir yetki yok!";
                break;
        }
    }
    function SystemDeleteUser($SystemUserId)
    {
        $CreateQuery = $this->db->prepare("DELETE FROM sistem_kullanici WHERE sistem_kullanici_id = ?");
        $CreateQuery->execute([$SystemUserId]);
        if ($CreateQuery) {
            return 1; // Silindi
        } else {
            return 0; // Silinmedi
        }
    }
    function CheckUser($SystemUserId)
    {
        $CreateQuery = $this->db->prepare("SELECT * FROM sistem_kullanici WHERE sistem_k_id = ?");
        $CreateQuery->execute([$SystemUserId]);
        $WriteQuery = $CreateQuery->fetch(PDO::FETCH_ASSOC);
        return $WriteQuery;
    }
    function GetPersonelProperties($id)
    {
        $CreateQuery = $this->db->prepare("SELECT * FROM kullanicilar WHERE kullanici_id = ? ");
        $CreateQuery->execute([$id]);
        if ($CreateQuery) {
            $WriteQuery = $CreateQuery->fetch(PDO::FETCH_ASSOC); //Başarılı
            return $WriteQuery;
        } else {
            return 0; //Başarısız
        }
    }
    function DeletePersonel($id)
    {
        $CreateQuery = $this->db->prepare("DELETE FROM kullanicilar WHERE kullanici_id = ? ");
        $CreateQuery->execute([$id]);
        if ($CreateQuery) {
            return 1; // Silme işlemi başarılı
        } else {
            return 0; //Silme işlemi başarısız
        }
    }
    function UpdateDuyuru($duyurutext)
    {
        $CreateQuery = $this->db->prepare("UPDATE duyuru SET duyuru_text = ? , duyuru_date = ?");
        $CreateQuery->execute([$duyurutext, date("Y-m-d H:i:s")]);
        if ($CreateQuery) {
            return 1; //Başarıyla güncellendi
        } else {
            return 0; //Güncellenme başarısız
        }
    }
    function GetUpdateText()
    {
        $CreateQuery = $this->db->query("SELECT * FROM duyuru");
        $WriteQuery = $CreateQuery->fetch(PDO::FETCH_ASSOC);
        return $WriteQuery;
    }
    function AddObjectToDatabase($seri_no, $kategori, $aciklama, $durum, $ekleyen_kisi, $zimmet_kisi)
    {
        $CreateQuery = $this->db->prepare("INSERT INTO esyalar SET esya_seri_no = ? , esya_kategori_id = ? , esya_aciklama = ?, esya_durumu = ? , esya_ekleyen_name = ? , esya_eklenme_tarih = ? , esya_ait_personel_id = ? ,esya_fotograf= 0");
        $CreateQuery->execute([$seri_no, $kategori, $aciklama, $durum, $ekleyen_kisi, date("Y-m-d H:i:s") , $zimmet_kisi]);
        if ($CreateQuery) {
            return 1; //Eklendi
        } else {
            return 0; //Eklenmedi
        }
    }
    function AddStatus($statusName)
    {
        $CreateQuery = $this->db->prepare("INSERT INTO durumlar SET durum_isim = ?");
        $CheckQuery = $CreateQuery->execute([$statusName]);
        if ($CheckQuery) {
            return 1; //Eklendi
        } else {
            return 0; //Eklenmedi
        }
    }
    function CheckStatus($check_no, $status_id = 0, $status_name = "")
    {
        if ($check_no == 0) {
            $CreateQuery_forid = $this->db->prepare("SELECT * FROM durumlar WHERE durum_id = ?");
            $CreateQuery_forid->execute([$status_id]);
            if ($CreateQuery_forid->rowCount() > 0) {
                return 1; // BU IDYE SAHİP DURUM VAR
            } else {
                return 0; // BU IDYE SAHİP DURUM YOK
            }
        } else if ($check_no == 1) {
            $CreateQuery_forname = $this->db->prepare("SELECT * FROM durumlar WHERE durum_isim = ?");
            $CreateQuery_forname->execute([$status_name]);
            if ($CreateQuery_forname->rowCount() > 0) {
                return 1; //BU İSME SAHİP BİR DURUM VAR
            } else {
                return 0; //BU İSME SAHİP BİR DURUM YOK
            }
        } else {
            $CreateQuery = $this->db->query("SELECT * FROM durumlar")->fetchAll(PDO::FETCH_ASSOC);
            return $CreateQuery;
        }
    }
    function StatusDelete(int $id)
    {
        $CreateQuery = $this->db->prepare("DELETE FROM durumlar WHERE durum_id = ?");
        $CreateQuery->execute([$id]);
        if ($CreateQuery) {
            return 1; //Silindi
        } else {
            return 0; //Silinmedi
        }
    }
    function GetObjects(int $checkno, int $id = 0)
    {
        if ($checkno == 0) {
            $CreateQuery = $this->db->query("SELECT * FROM esyalar");
            $WriteQuery = $CreateQuery->fetchAll(PDO::FETCH_ASSOC);
            return $WriteQuery;
        } else if ($checkno == 1) {
            $CreateQuery = $this->db->prepare("SELECT * FROM esyalar WHERE esya_id = ?");
            $CreateQuery->execute([$id]);
            $WriteQuery = $CreateQuery->fetch(PDO::FETCH_ASSOC);
            return $WriteQuery;
        }
    }
    function GetCategoryName(int $id)
    {
        $CreateQuery = $this->db->prepare("SELECT kategori_isim FROM kategoriler WHERE kategori_id = ?");
        $CreateQuery->execute([$id]);
        $writeQuery = $CreateQuery->fetch(PDO::FETCH_ASSOC);
        if (!$writeQuery) {
            return "Bilinmeyen";
        } else {
            return $writeQuery;
        }
    }
    function GetStatusName(int $id)
    {
        $CreateQuery = $this->db->prepare("SELECT durum_isim FROM durumlar WHERE durum_id = ?");
        $CreateQuery->execute([$id]);
        $WriteQuery = $CreateQuery->fetch(PDO::FETCH_ASSOC);
        if (!$WriteQuery) {
            return "Bilinmeyen";
        } else {
            return $WriteQuery;
        }
    }
    function DeleteObject(int $id)
    {
        $CreateQuery = $this->db->prepare("DELETE FROM esyalar WHERE esya_id = ?");
        $CreateQuery->execute([$id]);
        if ($CreateQuery) {
            return 1; //Silindi
        } else {
            return 0; //Silinmedi
        }
    }
    /**
     * Logstring değeri sadece string bir değer alır.
     * @param string $LogString Log kaydı olarak eklenicek metin.
     * @return int 1 veya 0 döner. 1 başarılı 0 başarısız
     */
    function LogAdd($LogString)
    {
        $CreateQuery = $this->db->prepare("INSERT INTO loglar (log_metin, log_olusturulma_tarih) VALUES (?, ?)");
        $CreateQuery->execute([$LogString, date("Y-m-d H:i:s")]);
        if ($CreateQuery) {
            return 1; //Eklendi
        } else {
            return 0; //Eklenmedi
        }
    }
    /**
     * Category idsini alıp veritabanındaki o idye sahip kategoriyi günceller
     * @param $category_id Kategori IDsi alınır
     * @param $cateogry_name Kategori ismi alınır
     * @return int 1 veya 0 döner. 1 başarılı 0 başarısız
     */
    function UpdateCategory($category_id, $category_name){
        if(intval($category_id) == 0){
            return "Gelen veri int türünde değil!";
        }
        else{
            $CreateQuery = $this->db->prepare("UPDATE kategoriler SET kategori_isim = ? WHERE kategori_id = ?");
            $CreateQuery->execute([$category_name,$category_id]);
            if($CreateQuery){
                return 1; //Başarılı
            }
            else{
                return 0; //Başarısız
            }
        }
    }
    /**
     * Status idsini alıp veritabanındaki o idye sahip statusu günceller
     * @param $status_id status IDsi alınır
     * @param $statusname status ismi alınır
     * @return int 1 veya 0 döner. 1 başarılı 0 başarısız
     */
    function UpdateStatus($status_id, $statusname){
        if(intval($status_id) == 0){
            return "Gelen veri int türünde değil!";
        }
        else{
            $CreateQuery = $this->db->prepare("UPDATE durumlar SET durum_isim = ? WHERE durum_id = ?");
            $CreateQuery->execute([$statusname,$status_id]);
            if($CreateQuery){
                return 1; //Başarılı
            }
            else{
                return 0; //Başarısız
            }
        }   
}
function UpdateRol($rol_id, $rol_name){
    if(intval($rol_id) == 0){
        return "Gelen veri int türünde değil!";
    }
    else{
        $CreateQuery = $this->db->prepare("UPDATE roller SET rol_name = ? WHERE rol_id = ?");
        $CreateQuery->execute([$rol_name,$rol_id]);
        if($CreateQuery){
            return 1; //Başarılı
        }
        else{
            return 0; //Başarısız
        }
    }
}
function GetRoleFromID($role_id){
    $CreateQuery = $this->db->prepare("SELECT rol_name FROM roller WHERE rol_id = ?");
    $CreateQuery->execute([$role_id]);
    if($CreateQuery){
        $WriteQuery = $CreateQuery->fetch(PDO::FETCH_ASSOC);
        return $WriteQuery;
    }
    else{
        return "Rol Bulunamadı!";
    }
}
/**
 * 
 * @param int $user_id Kullanıcı idsi
 * @param string $user_password Kullanıcı şifresi
 * @return int 1 veya 0 döner. 1 başarılı 0 başarısız
 * 
 */
function UpdateSystemPassword($user_id , $user_password){
    $createquery = $this->db->prepare("UPDATE sistem_kullanici SET sistem_k_sifre = ? WHERE sistem_k_id = ?");
    $createquery->execute([$user_password , $user_id]);
    if($createquery){
        return 1; //Başarılı
    }
    else{
        return 0; //Başarısız
    }
}
/**
 *  @param string $name Kullanıcı ismi
 * @param string $surname Kullanıcı soyismi
 * @param string $nickname Kullanıcı kullanıcı adı
 * @param string $rol Kullanıcı rolü
 * @param int $user_id Kullanıcı idsi
 * @param string $fotograf Kullanıcı fotoğrafı
 * @param int $durum Kullanıcı fotoğrafı var mı yok mu?
 * @return int 1 veya 0 döner. 1 başarılı 0 başarısız
 */
function UpdateSystemUserProperties($name, $surname, $nickname , $rol , $user_id, $fotograf, $durum){
    if($durum == 0){
        $createquery = $this->db->prepare("UPDATE sistem_kullanici SET sistem_k_isim = ? , sistem_k_soyisim = ? , sistem_k_kullaniciadi = ? , sistem_k_rol = ? WHERE sistem_k_id = ?");
        $createquery->execute([$name, $surname, $nickname, $rol, $user_id]);
        if($createquery){
            return 1; //Başarılı
        }
        else{
            return 0; //Başarısız
        }
    }
    else{
        $createquery = $this->db->prepare("UPDATE sistem_kullanici SET sistem_k_isim = ? , sistem_k_soyisim = ? , sistem_k_kullaniciadi = ? , sistem_k_rol = ? , sistem_k_profil = ? WHERE sistem_k_id = ?");
        $createquery->execute([$name, $surname, $nickname, $rol, $fotograf, $user_id]);
        if($createquery){
            return 1; //Başarılı
        }
        else{
            return 0; //Başarısız
        }
    }
    
}
function DownloadExcel(){
    $phpspreadsheet = new Spreadsheet();
$sheet = $phpspreadsheet->getActiveSheet();
$sayac = 2;
$GetObjectsData = $this->GetObjects(0, 0);
$styleArray = [
    'font' => [
        'bold' => true,
        'color' => ['rgb' => '#000000'],
        'size' => 16,
        'name' => 'Arial'
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
        'startColor' => ['rgb' => 'FFFFFF00'],
        'endColor' => ['rgb' => 'FFFFFF00']
    ],
];
$sheet->getStyle('A')->getFont()->setBold(true);
$sheet->getStyle('A')->getFont()->setSize(18);
$sheet->getStyle('A')->getFont()->setName('Arial');
$sheet->getStyle('B')->getFont()->setBold(true);
$sheet->getStyle('B')->getFont()->setSize(18);
$sheet->getStyle('B')->getFont()->setName('Arial');
$sheet->getStyle('C')->getFont()->setBold(true);
$sheet->getStyle('C')->getFont()->setSize(18);
$sheet->getStyle('C')->getFont()->setName('Arial');
$sheet->getStyle('D')->getFont()->setBold(true);
$sheet->getStyle('D')->getFont()->setSize(18);
$sheet->getStyle('D')->getFont()->setName('Arial');
$sheet->getStyle('E')->getFont()->setBold(true);
$sheet->getStyle('E')->getFont()->setSize(18);
$sheet->getStyle('E')->getFont()->setName('Arial');
$sheet->getStyle('F')->getFont()->setBold(true);
$sheet->getStyle('F')->getFont()->setSize(18);
$sheet->getStyle('F')->getFont()->setName('Arial');
$sheet->getStyle('G')->getFont()->setBold(true);
$sheet->getStyle('G')->getFont()->setSize(18);
$sheet->getStyle('H')->getFont()->setBold(true);
$sheet->getStyle('H')->getFont()->setSize(18);
$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->getColumnDimension('D')->setAutoSize(true);
$sheet->getColumnDimension('E')->setAutoSize(true);
$sheet->getColumnDimension('F')->setAutoSize(true);
$sheet->getColumnDimension('G')->setAutoSize(true);
$sheet->getColumnDimension('H')->setAutoSize(true);
$sheet->getStyle('A1')->applyFromArray($styleArray);
$sheet->getStyle('B1')->applyFromArray($styleArray);
$sheet->getStyle('C1')->applyFromArray($styleArray);
$sheet->getStyle('D1')->applyFromArray($styleArray);
$sheet->getStyle('E1')->applyFromArray($styleArray);
$sheet->getStyle('F1')->applyFromArray($styleArray);
$sheet->getStyle('G1')->applyFromArray($styleArray);
$sheet->getStyle('H1')->applyFromArray($styleArray);
foreach ($GetObjectsData as $key) {
    $sheet->setCellValue("A1", "ID");
    $sheet->setCellValue("B1", "Seri No");
    $sheet->setCellValue("C1", "Kategori ID");
    $sheet->setCellValue("D1", "Açıklama");
    $sheet->setCellValue("E1", "Durum");
    $sheet->setCellValue("F1", "Ait Personel ID");
    $sheet->setCellValue("G1", "Eşyayı Ekleyen Kişi");
    $sheet->setCellValue("H1", "Eklenme Tarihi");
    $sheet->setCellValue("A" . $sayac, $key["esya_id"]);
    $sheet->setCellValue("B" . $sayac, $key["esya_seri_no"]);
    $sheet->setCellValue("C" . $sayac, $key["esya_kategori_id"]);
    $sheet->setCellValue("D" . $sayac, $key["esya_aciklama"]);
    $sheet->setCellValue("E" . $sayac, $key["esya_durumu"]);
    $sheet->setCellValue("F" . $sayac, $key["esya_ait_personel_id"]);
    $sheet->setCellValue("G" . $sayac, $key["esya_ekleyen_name"]);
    $sheet->setCellValue("H" . $sayac, $this->DateFormater($key["esya_eklenme_tarih"]));
    $sayac++;
}
$writer = new Xlsx($phpspreadsheet);
$fileName = "esya_listesi.xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
ob_end_clean();
return $writer->save('php://output'); 
exit();
}
}

class DashboardClass extends DatabaseClass
{
    function GetObjectCount()
    {
        $CreateQuery = $this->db->query("SELECT * FROM esyalar");
        $Querycount = $CreateQuery->rowCount();
        return $Querycount;
    }
    function GetSystemUserCount()
    {
        $CreateQuery = $this->db->query("SELECT * from sistem_kullanici");
        $System_User_Count = $CreateQuery->rowCount();
        return $System_User_Count;
    }
}

class CheckUserInterface extends DatabaseClass
{
    /**
     * Kullanıcının yetkisini kontrol eder.
     * @param string $permisson Kullanıcının veritabanındaki yetki idsi
     * @return string JSON formatında yetki durumu döner veya 1 döner.
     * 
     */
    function SystemUserPermission($permission)
    {

        switch ($permission) {
            case 0:
                $sonuc  = ["status" => "Görüntüleyici", "color" => "green", "aciklama" => "yalnızca görüntüleme yetkisine sahipsiniz bundan dolayı herhangi bir ekleme , düzenleme ve silme işlemi gerçekleştiremezsiniz."];
                return json_encode($sonuc);
                break;

            default:
                return 1;   // Yetki var
                break;
        }
    }
}
