<?php
// src/Controller/Component/UtilitiesComponent.php
namespace App\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Controller\Component;
use Cake\Cache\Cache;

class UtilitiesComponent extends Component
{
    public $components = ['Auth','Acl.Acl'];
    
    public function message_alert($title,$no = 1){
        $array = [
            1 => 'Data '.$title.' berhasil disimpan',
            'Data '.$title.' gagal disimpan',
            'Data '.$title.' berhasil diedit',
            'Data '.$title.' gagal diedit',
            'Data '.$title.' berhasil dihapus',
            'Data '.$title.' gagal dihapus'
        ];
        return $array[$no];
    }

    public function monthArray()
    {
        $array = array (1 =>   'Januari',
                    'Februari',
                    'Maret',
                    'April',
                    'Mei',
                    'Juni',
                    'Juli',
                    'Agustus',
                    'September',
                    'Oktober',
                    'November',
                    'Desember'
                );
        return $array;
    }
    
    public function indonesiaDateFormat($tanggal,$time = false,$toIndonesia = true)
    {
        $bulan = $this->monthArray();
        $datepick = explode(" ", $tanggal);
        $split = explode("-", $datepick[0]);
        if($toIndonesia == true){
            if($time == false){
                return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
            }else{
                return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0]. ' ' . $datepick[1];
            }
        }else{
            if($time == false){
                return $split[2] . '-' . $split[1]. '-' . $split[0];
            }else{
                return $split[2] . '-' . $split[1] . '-' . $split[0].' '.$datepick[1];
            }
        }
        
    }  

    public function generalitationDateFormat($tanggal,$time = false)
    {
        $datepick = explode(" ", $tanggal);
        $split = explode("-", $datepick[0]);
        if($time){
            return $split[2] . '-' . $split[1] . '-' . $split[0]. " " . $datepick[1]; 
        }else{
            return $split[2] . '-' . $split[1] . '-' . $split[0]; 
        }
           
    }
    
	public function generalitationNumber($number){
        return str_replace(",","",$number);
    }

}

?>