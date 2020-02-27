<?php
namespace App\View\Helper;

use Cake\View\Helper;

class UtilitiesHelper extends Helper
{
    public $helpers = ['Url'];
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
    
    public function sideBarArrayCheck( array $array, $keys ) {
        $count = 0;
        if ( ! is_array( $keys ) ) {
            $keys = func_get_args();
            array_shift( $keys );
        }
        foreach ( $keys as $key ) {
            if ( isset( $array[$key] ) || array_key_exists( $key, $array ) ) {
                $count ++;
            }
        }
    
        return $count;
    }

    public function labelSettings($label){
        return str_replace(".","",$label);
    }

    public function statusLabel($label){
        if($label){
            return "<span class=\"m-badge m-badge--brand m-badge--wide\"> Aktif</span>";
        }else{
            return "<span class=\"m-badge m-badge--danger m-badge--wide\"> Tidak Akfif</span>";
        }
    }

    public function generateUrlAsset($img_dir=null,$img,$prefix = null,$img_not_found = null)
    {
		//full_path_dir
        $baseDir = "";
        if($img_dir == null){
            $img_dir = $img;
            if(substr($img_dir,0,1) == "/" || substr($img_dir,0,1) == "\""){
                $img_dir = substr($img_dir,1);
            }
            $changeSlash 		= str_replace("\\",DS,$img_dir);
            $changeSlash		= str_replace("/",DS,$changeSlash); 
            $changeSlash        = str_replace("webroot\\","",$changeSlash);
            $changeSlash        = str_replace("webroot/","",$changeSlash);
            $full_path = WWW_ROOT.$changeSlash;
            $noDir = true;
        }else{
            $img_dir = $baseDir.$img_dir."/";
            $img = $prefix.$img;
            $changeSlash 		= str_replace("\\",DS,$img_dir);
            $changeSlash		= str_replace("/",DS,$changeSlash); 
            $full_path = ROOT.DS.$changeSlash.$img;
            $noDir = false;
        }
        
		//check image exist
		if(file_exists($full_path)){
            if($noDir == false){
                $dir 		= str_replace("\\","/",$img_dir).$img;
            }else{
                $dir 		= str_replace("\\","/",$img_dir);
            }
			$dir = str_replace("webroot/","",$dir);
			$url = $this->Url->build("/".$dir,true);
		}else{
			if($img_not_found == null){
				$url = $this->Url->build("/img/no-image.png",true);
			}else{
				$url = $this->Url->build("/".$img_not_found,true);
			}
		}
		return $url;
    }

}