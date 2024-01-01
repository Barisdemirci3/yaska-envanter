<?php 
class DatabaseClass {
    public $db, $sql; 

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=envanter-takip', "root", "root");
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    function sorgu($syntax){
        // Sorguyu hazırla ve çalıştır
        $this->sql = $this->db->query($syntax);
        return $this->sql; // PDOStatement nesnesini döndür
    }

    function InsertKullanici($ad, $soyad, $kullaniciadi, $kullanicimail, $kullanicisifre, $kullaniciisebaslangic, $kullanicidepartman, $kullanicirutbe, $kullaniciyetki){
        $create = $this->db->prepare("INSERT INTO kullanicilar (kullanici_isim, kullanici_soyisim, kullanici_kullanici_adi, kullanici_mail, kullanici_sifre, kullanici_ise_baslangic, kullanici_departman, kullanici_rutbe, kullanici_yetki) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $create->execute([$ad, $soyad, $kullaniciadi, $kullanicimail, $kullanicisifre, $kullaniciisebaslangic, $kullanicidepartman, $kullanicirutbe, $kullaniciyetki]);
    }
    
    function CheckKullanici($nickname, $password){
        $check = $this->db->prepare("SELECT * FROM kullanicilar WHERE kullanici_kullanici_adi = ? AND kullanici_sifre = ?");
        $check->execute([$nickname, $password]);
    }
}
?>
