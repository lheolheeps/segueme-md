<?php

/**
 * Class de criptografia de dados
 *
 * @author Igor da Hora
 */
class SecurityEncryptionHelper {

    /**
     * Gera uma criptografia de um texto ou palavra
     * @param string $word Texto ou palavra a ser codificado
     * @param array $dados Configuração da encryptação
     * @return string
     */
    public static function encrypt($word, $dados = null) {

        $config = ($dados === null) ? parse_ini_file(PATH_CONFIG . 'config.ini', true) : $dados;
        if (isset($config['encrypt']['cod_base']) && isset($config['encrypt']['frase_segura'])) {

            $frase = (string) $config['encrypt']['frase_segura'];
            if ($dados === null) {
                $frase = md5(sha1($frase));
            }

            $word .= $frase;
            $s = strlen($word) + 1;
            $nw = "";
            $n = (int) $config['encrypt']['cod_base'];
            for ($x = 1; $x < $s; $x++) {
                $m = $x * $n;
                if ($m > $s) {
                    $nindex = $m % $s;
                } else if ($m < $s) {
                    $nindex = $m;
                }
                if ($m % $s == 0) {
                    $nindex = $x;
                }
                $nw = $nw . $word[$nindex - 1];
            }
            return $nw;
        } else {
            return false;
        }
    }

    /**
     * Descriptografar um texto ou palavra
     * @param string $word Texto ou palavra a ser descodificado
     * @param array $dados Configuração da dencryptação
     * @return string
     */
    public static function decrypt($word, $dados = null) {

        $config = ($dados === null) ? parse_ini_file(PATH_CONFIG . 'config.ini', true) : $dados;

        if (isset($config['encrypt']['cod_base']) && isset($config['encrypt']['frase_segura'])) {

            $frase = (string) $config['encrypt']['frase_segura'];
            $frase = md5(sha1($frase));

            $s = strlen($word) + 1;
            $nw = "";
            $n = (int) $config['encrypt']['cod_base'];
            for ($y = 1; $y < $s; $y++) {
                $m = $y * $n;
                if ($m % $s == 1) {
                    $n = $y;
                    break;
                }
            }
            for ($x = 1; $x < $s; $x++) {
                $m = $x * $n;
                if ($m > $s) {
                    $nindex = $m % $s;
                } else if ($m < $s) {
                    $nindex = $m;
                }
                if ($m % $s == 0) {
                    $nindex = $x;
                }
                $nw = $nw . $word[$nindex - 1];
            }
            $t = strlen($nw) - strlen($frase);
            unset($config,$frase,$s,$n);
            return substr($nw, 0, $t);
        } else {
            unset($config);
            return false;
        }
    }
    
    public static function getEncrypt($word,$dados = null) {
        $word = str_replace(' ','esc4',$word);
        $word = str_replace("'",'esc1',$word);
        $word = str_replace("`",'esc2',$word);
        $encrypt = SecurityEncryptionHelper::encrypt(htmlentities($word),$dados);
        $encrypt = str_replace('&','esc3', $encrypt);
        $encrypt = str_replace(';','esc5', $encrypt);
        return $encrypt;
    }

    public static function getDecrypt($word,$dados = null) {
        $word = str_replace('esc3','&', $word);
        $word = str_replace('esc5',';', $word);
        $decrypt = SecurityEncryptionHelper::decrypt($word,$dados);
        $decrypt = html_entity_decode($decrypt);
        $decrypt = str_replace('esc4',' ',$decrypt);
        $decrypt = str_replace('esc1',"'",$decrypt);
        $decrypt = str_replace('esc2',"`",$decrypt);
        return $decrypt;
    }
}
